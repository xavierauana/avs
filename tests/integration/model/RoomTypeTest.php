<?php

use App\Reservation;
use App\ReservationNight;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTypeTest extends TestCase
{
    use DatabaseTransactions;

    protected $availability = 10;
    protected $code = 'default';

    protected function set_a_roomType()
    {
        $property = create_properties();

        return $property->roomTypes()->create([
            'code'         => $this->code,
            'availability' => $this->availability,
        ]);
    }

    /** @test */
    public function room_types_default()
    {
        $roomType = $this->set_a_roomType();

        $this->assertEquals('default', $roomType->code);
        $this->assertEquals(10, $roomType->availability);
    }

    /** @test */
    function get_room_type_availability()
    {
        $roomType = $this->set_a_roomType();
        $this->assertEquals($this->availability, $roomType->availability);
    }

    /** @test */
    function get_room_type_availability_by_checking_rooms_calendar_with_no_reservation()
    {
        // 1. is empty reservation, should return same as default availability
        $roomType = $this->set_a_roomType();
        $reservations = ReservationNight::where('date', date('Y-m-d'))->whereRoomTypeId($roomType->id)->get();
        $this->assertEquals($roomType->availability, $roomType->availability - $reservations->count());
    }

}
