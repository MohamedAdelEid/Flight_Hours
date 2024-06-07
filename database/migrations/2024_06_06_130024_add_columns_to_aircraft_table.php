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
        Schema::table('aircrafts', function (Blueprint $table) {
            $table->string('manufacturer', 255)->after('aircraft_code');
            $table->enum('status', ['active', 'inactive', 'maintenance'])->after('manufacturer');
            $table->string('registration_number', 20)->after('status')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aircraft', function (Blueprint $table) {
            $table->dropIfExists('manufacturer');
            $table->dropIfExists('status');
            $table->dropIfExists('registration_number');
        });
    }
};
