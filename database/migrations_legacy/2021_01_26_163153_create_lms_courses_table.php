<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmsCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'expert'])->default('beginner');
            $table->foreignId('category_id')->nullable();
            $table->foreignId('author_id')->references('id')->on('users');
            $table->enum('type', ['free', 'paid'])->default('free');
            $table->float('price')->nullable();
            $table->float('sale_price')->nullable();
            $table->float('duration')->default(0);
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->boolean('is_new')->default(0);
            $table->boolean('is_published')->default(0);
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
        Schema::dropIfExists('lms_courses');
    }
}
