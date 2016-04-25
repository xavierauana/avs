<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable =[
        'country', 'state', 'city', 'street', 'building'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
