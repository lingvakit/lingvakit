<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmsPresentationSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_presentation_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentation_id')->references('id')->on('lms_lesson_presentation');
            $table->foreignId('image')->references('id')->on('media_files')->cascadeOnDelete();
            $table->bigInteger('slide_number');
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
        Schema::dropIfExists('lms_presentation_slides');
    }
}
