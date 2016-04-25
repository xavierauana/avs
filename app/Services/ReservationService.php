<?php
/**
 * Author: Xavier Au
 * Date: 7/1/16
 * Time: 6:14 PM
 */

namespace App\Services;


use App\Exceptions\CheckInAndCheckOutDateException;
use App\Exceptions\DateFormattingException;
use App\Exceptions\RoomTypeIsFullException;
use App\Reservation;
use App\ReservationNight;
use App\RoomType;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    public function make(User $user, RoomType $roomType, int $occupancy, string $checkInDate, string $checkOutDate): Reservation
    {
        $this->validateArguments($checkInDate, $checkOutDate);
        $this->checkRoomTypeAvailability($roomType, $occupancy, $checkInDate, $checkOutDate);
        $reservation = $this->persistReservationRecord($user, $roomType, $occupancy, $checkInDate, $checkOutDate);
        return $reservation;
    }

    protected function checkDatesAreCorrect(string $checkInDateString, string $checkOutDateString){
        $checkInDate = new Carbon($checkInDateString);
        $checkOutDate = new Carbon($checkOutDateString);
        if(!$checkOutDate->gt($checkInDate)) throw new CheckInAndCheckOutDateException;
    }

    private function parseDateToCarbonObject(string $checkInDate, string $checkOutDate)
    {
        try{
            new Carbon($checkInDate);
            new Carbon($checkOutDate);
        }catch (\Exception $e){
            throw new DateFormattingException;
        }
    }

    private function checkRoomTypeAvailability(RoomType $roomType, int $occupancy, string $checkInDateString, string $checkOutDateString)
    {
        $checkInDate = new Carbon($checkInDateString);
        $checkOutDate = new Carbon($checkOutDateString);
        while($checkOutDate->gt($checkInDate)){
            if(!$roomType->isAvailableOnDateForOccupancy($checkInDate->format('Y-m-d'), $occupancy)) throw new RoomTypeIsFullException;
            $checkInDate->addDay();
        }
    }

    private function validateArguments(string $checkInDate, string $checkOutDate)
    {
        $this->parseDateToCarbonObject($checkInDate, $checkOutDate);
        $this->checkDatesAreCorrect($checkInDate,$checkOutDate);
    }

    /**
     * @param \App\User            $user
     * @param \App\RoomType        $roomType
     * @param \App\Services\int    $occupancy
     * @param \App\Services\string $checkInDate
     * @param \App\Services\string $checkOutDate
     * @return static
     */
    private function persistReservationRecord(
        User $user,
        RoomType $roomType,
        int $occupancy,
        string $checkInDate,
        string $checkOutDate
    ):Reservation {
        $newCheckIn = new Carbon($checkInDate);
        $newCheckOut = new Carbon($checkOutDate);
        $reservation = Reservation::create([
            'user_id'   => $user->id,
            'occupancy' => $occupancy,
            'property_id' => $roomType->property->id,
            'check_in'  => $newCheckIn->format('Y-m-d'),
            'check_out' => $newCheckOut->format('Y-m-d'),
        ]);
        while ($newCheckOut->gt($newCheckIn)) {
            for ($i = 0; $i < $occupancy; $i++) {
                $reservation->reservationNights()->create([
                    'date'           => $newCheckIn->format('Y-m-d'),
                    'room_type_id'   => $roomType->id
                ]);
                $calendar = $roomType->calendar()->where('date',$newCheckIn->format('Y-m-d'))->first();
                $calendar->update(['availability'=>$calendar->availability - 1]);
            }

            $newCheckIn->addDay();
        }

        return $reservation;
    }

    public function getMyReservations(int $reservationId=null)
    {
        if($user = Auth::user()){
            if($reservationId){
                $reservation = $user->reservations()->standardComponents()->find($reservationId);
                return $reservation;
            }else{
                $reservations = $user->reservations()->standardComponents()->get();
                return $reservations;
            }

        }
    }

}