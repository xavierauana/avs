<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationNight extends Model
{
    protected $fillable = [
        'date', 'room_type_id', 'reservation_id'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
