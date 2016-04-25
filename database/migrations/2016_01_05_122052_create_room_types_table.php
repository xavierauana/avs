<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('occupancy')->unsigned()->default(1);
            $table->integer('availability')->unsigned()->default(1);

            $table->double('base_price')->nullable();
            $table->double('weekly_price')->nullable();
            $table->double('monthly_price')->nullable();

            $table->enum('currency',['hkd', 'usd'])->default('hkd');

            $table->integer('bedrooms')->default(-1);
            $table->integer('beds')->default(-1);
            $table->integer('bathrooms')->default(-1);

            $table->text('description')->unllable();

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->integer('room_type_list_id')->unsigned();
            $table->foreign('room_type_list_id')->references('id')->on('room_type_lists')->onDelete('cascade');
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
        Schema::drop('room_types');
    }
}
