<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
        Schema::create('message_room_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('message_room_id')->unsigned();
            $table->primary(['user_id', 'message_room_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message_room_user');
        Schema::drop('message_rooms');
    }
}
