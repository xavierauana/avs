<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Room extends TestCase
{
    use DatabaseTransactions;

    protected function set_a_property(){
        return factory(\App\Property::class)->create(['property_type_id'=>factory(\App\PropertyType::class)->create()->id]);
    }

    /** @test */
    public function room_types_default()
    {
        $params = [
            'code' => 'default',
            'availability' => 10
        ];
        $property = create_properties();
        $roomType = $property->roomTypes()->create($params);

        $this->assertEquals('default', $roomType->code);
        $this->assertEquals(10, $roomType->availability);
    }
}
