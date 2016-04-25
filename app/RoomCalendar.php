<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCalendar extends Model
{
    protected $fillable = [
        'availability','date'
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_id');
    }
}
