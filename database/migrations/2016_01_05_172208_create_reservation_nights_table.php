<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationNightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_nights', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('room_type_id')->unsigned();
            $table->integer('reservation_id')->unsigned();
//            $table->integer('room_id')->unsigned();

            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
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
        Schema::drop('reservation_nights');
    }
}
