<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_home_work_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->references('id')->on('lms_lesson_home_works')->cascadeOnDelete();
            $table->foreignId('student_id')->references('id')->on('users')->cascadeOnDelete();
            $table->text('student_comment')->nullable();
            $table->integer('assessment')->nullable();
            $table->dateTime('upload_date');
            $table->dateTime('check_date')->nullable();
            $table->string('student_file_path');
            $table->text('teacher_comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lms_home_work_results');
    }
};
