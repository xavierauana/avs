<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTypeList extends Model
{
    protected $fillable = [
      'label', 'code'
    ];
}
