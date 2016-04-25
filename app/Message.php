<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'message', 'user_id', 'message_room_id'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function messageRoom()
    {
        return $this->belongsTo(MessageRoom::class);
    }
}
