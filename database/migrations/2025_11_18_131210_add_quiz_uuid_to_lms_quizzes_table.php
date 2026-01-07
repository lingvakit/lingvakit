<?php

use App\Models\LMS\Quiz;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Uuid;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lms_quizzes', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        Quiz::chunk(100, function ($quizzes) {
            foreach ($quizzes as $quiz) {
                $quiz->uuid = Uuid::v4();
                $quiz->save();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lms_quizzes', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
