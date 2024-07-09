<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCrewsFlightsTable extends Migration
{
    public function up()
    {
        Schema::table('crews_flights', function (Blueprint $table) {
            $table->dropColumn(['flight_id']);
            $table->foreign('flight_id')->references('id')->on('other_flights')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('crews_flights', function (Blueprint $table) {
            $table->dropForeign(['flight_id']);
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
        });
    }
}

