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
            $table->time('departure_time')->change();
            $table->time('arrival_time')->change();
            $table->time('door_closed_at')->after('destination_airport_id');
            $table->time('door_opened_at')->after('door_closed_at');
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
