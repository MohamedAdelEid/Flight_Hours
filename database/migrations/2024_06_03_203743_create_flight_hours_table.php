<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightHoursTable extends Migration
{
    public function up()
    {
        Schema::create('flight_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aircraft_id');
            $table->unsignedBigInteger('flight_id');
            $table->decimal('hours', 5, 2);
            $table->timestamps();

            $table->foreign('aircraft_id')->references('id')->on('aircrafts')->onDelete('cascade');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('flight_hours');
    }
}
