<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRoom extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
