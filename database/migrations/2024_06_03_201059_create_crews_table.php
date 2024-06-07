<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrewsTable extends Migration
{
    public function up()
    {
        Schema::create('crews', function (Blueprint $table) {
            $table->id(); // رقم التسلسل
            $table->string('financial_number')->notNull();
            $table->string('first_name')->notNull(); // الأسم
            $table->string('last_name')->notNull(); // اسم الأب
            $table->string('nickname')->nullable(); // اللقب
            $table->date('date_of_birth')->notNull(); // تاريخ الميلاد
            $table->string('aircraft_type')->notNull(); // الطراز الذي يطير عليه
            $table->string('license_number')->notNull(); // رقم الرخصة
            $table->unsignedBigInteger('job_id')->notNull(); // الوظيفة (captain, etc) (foreign key referencing jobs)
            $table->enum('status', ['فعال', 'غير فعال'])->notNull(); // الحالة (فعال / غير فعال)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crews');
    }
}
