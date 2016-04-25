<?php

use App\Media;
use App\Property;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PropertyTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    function its_setup_correct()
    {
        $param = [
            'name'             => 'name',
            'description'      => serialize(['code' => 'description']),
            'property_type_id' => factory(\App\PropertyType::class)->create()->id,
            'owner_id'         => factory(\App\User::class)->create()->id
        ];
        $property = Property::create($param);
        $this->assertEquals('App\Property', get_class($property));
    }

    /** @test */
    public function fetch_room_types()
    {
        $property = create_properties();
        $roomTypeParams = [
            'property_id' => $property->id
        ];
        factory(\App\RoomType::class, 3)->create($roomTypeParams);

        $roomTypes = $property->roomTypes;

        $this->assertEquals(3, $roomTypes->count());
    }

    /** @test */
    function it_can_has_multiple_roomTypes_only_when_it_explicitly_set_to()
    {
        $property1 = create_properties(null, null, true);
        $property2 = create_properties();

        $type1 = $property1->createNewRoomType(['code' => 'a', 'availability' => 1]);
        $this->assertEquals('a', $type1->code);
        $type2 = $property1->createNewRoomType(['code' => 'b', 'availability' => 1]);
        $this->assertEquals('b', $type2->code);

        $type3 = $property2->createNewRoomType(['code' => 'c', 'availability' => 1]);
        $this->assertEquals('c', $type3->code);
        $this->setExpectedException('App\Exceptions\CannotHaveMultipleRoomTypes');
        $type4 = $property2->createNewRoomType(['code' => 'd', 'availability' => 1]);
        $this->assertEquals('d', $type4->code);
    }

    /** @test */
    function it_has_one_owner()
    {
        $property = create_properties();
        $this->assertEquals('App\User', get_class($property->owner));
    }

    /** @test */
    function it_has_media(){

        $property = create_properties();
        $media1 = $property->addMedia(['link'=>'abc', 'type'=>'image']);
        $media2 = $property->addMedia(['link'=>'cde', 'type'=>'image']);

        $this->assertEquals(Media::class, get_class($media1));

        $this->seeInDatabase('media',[
            'id'=>$media1->id,
            'owner_id'=>$property->id,
            'owner_type'=>get_class($property)
        ]);

        $this->assertEquals(2,$property->media->count());

    }
}
