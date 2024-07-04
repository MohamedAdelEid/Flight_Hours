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
        Schema::table('crews_flights', function (Blueprint $table) {
            $table->time('training_start_at')->after('crew_id')->nullable();
            $table->time('training_end_at')->after('training_start_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crews_flights', function (Blueprint $table) {
            //
        });
    }
};
