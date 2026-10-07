<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmsResultAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_result_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->references('id')->on('lms_results');
            $table->foreignId('question_id')->references('id')->on('lms_questions');
            $table->foreignId('conformity_id')->references('id')->on('lms_conformity');
            $table->foreignId('option_id')->references('id')->on('lms_conformity_options');
            $table->string('value')->nullable();
            $table->boolean('is_correct');
//            $table->float('points')->default(0);
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
        Schema::dropIfExists('lms_result_answers');
    }
}
