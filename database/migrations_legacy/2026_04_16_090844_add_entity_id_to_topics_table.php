<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lms_topics', function (Blueprint $table) {
            $table->uuid('entity_id')
                ->unique()
                ->nullable()
                ->after('id');
        });
    }

    public function down()
    {
        Schema::table('lms_topics', function (Blueprint $table) {
            $table->dropColumn('entity_id');
        });
    }
};
