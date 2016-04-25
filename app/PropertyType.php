<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = [
      'is_multiple','label', 'code'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
