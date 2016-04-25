<?php

use App\Reservation as Re;
use App\ReservationNight;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Reservation extends TestCase
{
    use DatabaseTransactions;

    protected $checkInDate;
    protected $checkOutDate;
    protected $duration = 5;

    protected function set_up_date_objects(){
        $this->checkInDate = new \Carbon\Carbon('2015-10-1');
        $this->checkOutDate = (new \Carbon\Carbon('2015-10-1'))->addDays($this->duration);
    }

    protected function set_a_roomType()
    {
        $property = factory(\App\Property::class)->create(['property_type_id' => factory(\App\PropertyType::class)->create()->id]);

        return $property->roomTypes()->create([
            'code'         => 'default',
            'availability' => 10,
        ]);
    }

    /** @test */
    function it_always_true(){
        $this->assertTrue(true);
    }
}
