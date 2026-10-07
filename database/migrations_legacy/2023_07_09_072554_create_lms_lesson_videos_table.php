<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_lesson_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->references('id')->on('lms_lessons')->cascadeOnDelete();
            $table->unsignedBigInteger('video');
            $table->unsignedBigInteger('poster')->nullable();
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
        Schema::dropIfExists('lms_lesson_videos');
    }
};
