<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('crew_normal_flights', function (Blueprint $table) {
            $table->unsignedBigInteger('job_id')->nullable()->after('crew_id');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');
        });

        Schema::table('crews_flights', function (Blueprint $table) {
            $table->unsignedBigInteger('job_id')->nullable()->after('crew_id');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('crew_normal_flights', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');
        });

        Schema::table('crews_flights', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropColumn('job_id');
        });
    }
};
