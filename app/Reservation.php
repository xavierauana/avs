<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable =[
        'occupancy', 'check_in', 'check_out', 'user_id'
    ];

    protected $dates =[
      'created_at', 'updated_at', 'check_in', 'check_out'
    ];

    public function reservationNights()
    {
        return $this->hasMany(ReservationNight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function scopeStandardComponents($query){
        return $query->with([
            'reservationNights'=>function($query){
                $query->with(['roomType']);
            },
            'property'
        ]);
    }
}
