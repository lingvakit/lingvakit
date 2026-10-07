<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_course_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->references('id')->on('lms_courses');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->text('review')->nullable();
            $table->integer('grade');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_reviews');
    }
}
