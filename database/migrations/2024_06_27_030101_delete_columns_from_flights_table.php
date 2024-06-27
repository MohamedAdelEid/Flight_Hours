<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('door_closed_at');
            $table->dropColumn('door_opened_at');
            $table->dropColumn('landing_time');
            $table->string('aircraft_number');
            $table->enum('flight_type',
                ['normal_flight','simulated_flight','unloaded_flight','airplane_test']
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            //
        });
    }
};
