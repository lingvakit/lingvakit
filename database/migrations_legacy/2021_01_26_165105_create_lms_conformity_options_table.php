<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLmsConformityOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lms_conformity_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conformity_id')->references('id')->on('lms_conformity');
            $table->string('value')->nullable();
            $table->boolean('is_correct')->nullable();
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
        Schema::dropIfExists('lms_conformity_options');
    }
}
