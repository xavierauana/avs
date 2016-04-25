<?php
/**
 * Author: Xavier Au
 * Date: 31/1/16
 * Time: 7:49 PM
 */

namespace App\Services;


use App\Property;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SearchProperties
{
    public function filterOccupancy(Collection $collection, $occupancy): Collection
    {
        return $collection->filter(function ($property) use ($occupancy) {
            $check = false;
            foreach ($property->roomTypes as $roomType) {
                if ($roomType->occupancy >= $occupancy) {
                    $check = true;
                    break;
                }
            }

            return $check;
        });
    }

    public function filterByDates(Collection $collection, Carbon $checkInDate, Carbon $checkOutDate): Collection
    {
        return $collection->filter(function ($property) use ($checkInDate, $checkOutDate) {
            $available = false;
            foreach ($property->roomTypes as $roomType) {
                $checkingDate = $checkInDate;
                $roomTypeAvailability = true;
                while ($checkOutDate->gt($checkingDate)) {
                    if ($roomType->isAvailable($checkingDate->toDateString())) {
                        $checkingDate->addDay();
                    } else {
                        $roomTypeAvailability = false;
                        break;
                    }
                }
                if ($roomTypeAvailability) {
                    $available = true;
                }
            }
            if ($available) {
                return $property;
            }
        });
    }

    public function fetchProperties($propertyTypeId = null): Collection
    {
        return $propertyTypeId ? Property::with('roomtypes', 'media',
            'propertyType')->wherePropertyTypeId($propertyTypeId)->get() : Property::with('roomtypes', 'media',
            'propertyType')->get();

    }
}