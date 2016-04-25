<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{
    use DatabaseTransactions;

    public $checkInDate = '2015/12/23';
    public $checkOutDate = '2015/12/26';

    protected function setting()
    {
        $user = create_user();
        $roomType = factory(\App\RoomType::class, 'single')->create(['availability' => 2]);
        $reservation = new \App\Services\ReservationService();

        return [$user, $roomType, $reservation];
    }

    /** @test */
    public function check_make_method()
    {
        list($user, $roomType, $reservation) = $this->setting();
        $reservation->make($user, $roomType, 1, $this->checkInDate, $this->checkOutDate);
        $this->assertTrue(true);
    }

    /** @test */
    function it_throw_CheckInAndCheckOutDateException_when_checkOutDate_greater_than_checkInDate()
    {
        list($user, $roomType, $reservation) = $this->setting();
        $this->setExpectedException('App\Exceptions\CheckInAndCheckOutDateException');
        $reservation->make($user, $roomType, 1, $this->checkOutDate, $this->checkInDate);
    }

    /** @test */
    function it_throw_DateFormattingException_when_checkOutDate_or_checkInDate_with_incorrect_formatting()
    {
        list($user, $roomType, $reservation) = $this->setting();
        $this->setExpectedException('App\Exceptions\DateFormattingException');
        $checkInDate = 'abc';
        $checkOutDate = '12345';
        $reservation->make($user, $roomType, 1, $checkOutDate, $checkInDate);
    }

    /** @test */
    function it_throw_RoomTyeIsFullException()
    {
        list($user, $roomType, $reservation) = $this->setting();
        $this->setExpectedException('App\Exceptions\RoomTypeIsFullException');
        $reservation->make($user, $roomType, 3, $this->checkInDate, $this->checkOutDate);
    }

    /** @test */
    function its_reservationNights_is_correct()
    {
        $occupancy = 2;

        list($user, $roomType, $reservationService) = $this->setting();
        $CarbonCheckIn = new \Carbon\Carbon($this->checkInDate);
        $CarbonCheckOut = new \Carbon\Carbon($this->checkOutDate);
        $numberOfNights = $CarbonCheckOut->diffInDays($CarbonCheckIn);
        $reservation = $reservationService->make($user, $roomType, $occupancy, $this->checkInDate, $this->checkOutDate);
        while ($CarbonCheckOut->gt($CarbonCheckIn)) {
            $this->assertEquals($roomType->availability - $occupancy,
                $roomType->getAvailability($CarbonCheckIn->format('Y-m-d')));
            $CarbonCheckIn->addDay();
        }
        $totalNumberOfNight = $occupancy * $numberOfNights;
        $this->assertEquals($totalNumberOfNight, $reservation->reservationNights->count());
    }

}
