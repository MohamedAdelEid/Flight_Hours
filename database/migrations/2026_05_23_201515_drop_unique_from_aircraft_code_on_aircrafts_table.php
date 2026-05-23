<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->dropUnique(['aircraft_code']);
        });
    }

    public function down(): void
    {
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->unique('aircraft_code');
        });
    }
};
