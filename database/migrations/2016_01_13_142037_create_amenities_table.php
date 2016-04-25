<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('code');
            $table->boolean('is_room');
            $table->string('category');
            $table->timestamps();
        });
        Schema::create('amenowners', function (Blueprint $table) {
            $table->integer('amenities_id')->unsigned()->index();
            $table->integer('amenowner_id')->unsigned()->index();
            $table->string('amenowner_type');
            $table->primary(['amenities_id', 'amenowner_id', 'amenowner_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amenowners');
        Schema::drop('amenities');
    }
}
