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
        Schema::table('other_flights', function (Blueprint $table) {
            $table->enum('flight_type',['simulated_flight','unloaded_flight','airplane_test'])
                ->after('flight_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('other_flights', function (Blueprint $table) {
            //
        });
    }
};
