<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE flights MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending_review'");

        DB::table('flights')->where('status', 'pending')->update(['status' => 'pending_review']);
        DB::table('flights')->where('status', 'cancelled')->update(['status' => 'rejected']);

        DB::statement("ALTER TABLE flights MODIFY COLUMN status ENUM('pending_review','completed','rejected') NOT NULL DEFAULT 'pending_review'");

        Schema::table('flights', function (Blueprint $table) {
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->text('rejection_reason')->nullable()->after('reviewed_at');
        });
    }

    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['reviewed_by', 'reviewed_at', 'rejection_reason']);
        });

        DB::statement("ALTER TABLE flights MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending'");

        DB::table('flights')->where('status', 'pending_review')->update(['status' => 'pending']);
        DB::table('flights')->where('status', 'rejected')->update(['status' => 'cancelled']);

        DB::statement("ALTER TABLE flights MODIFY COLUMN status ENUM('pending','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
