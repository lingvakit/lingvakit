<?php
declare(strict_types=1);

use App\UI\Http\Api\Admin\Controllers\Category\CategoryListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseCreateController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseShowController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseUpdateController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonCreateController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonDeleteController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonShowController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonUpdateController;
use App\UI\Http\Api\Admin\Controllers\Media\MediaFileListController;
use App\UI\Http\Api\Admin\Controllers\Media\MediaFileUploadController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleCreateController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleShowController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleUpdateController;
use App\UI\Http\Api\Admin\Controllers\Question\QuestionAnswerPatchController;
use App\UI\Http\Api\Admin\Controllers\Question\QuestionCreateController;
use App\UI\Http\Api\Admin\Controllers\QuestionsGroup\QuestionsGroupCreateController;
use App\UI\Http\Api\Admin\Controllers\QuestionsGroup\QuestionsGroupDetailsController;
use App\UI\Http\Api\Admin\Controllers\QuestionsGroup\QuestionsGroupUpdateController;
use App\UI\Http\Api\Admin\Controllers\Quiz\QuizCreateController;
use App\UI\Http\Api\Admin\Controllers\Quiz\QuizDetailsController;
use App\UI\Http\Api\Admin\Controllers\Quiz\QuizUpdateController;

Route::middleware(['web', 'auth', 'role:admin|teacher|superuser'])
    ->prefix('react/api')
    ->name('react.')
    ->group(function () {
        Route::prefix('media')->name('media.')->group(function (): void {
            Route::get('/', MediaFileListController::class)
                ->name('index');
            Route::post('/upload', MediaFileUploadController::class)
                ->middleware('throttle:30,1')
                ->name('upload');;
        });

        Route::get('categories', CategoryListController::class);

        Route::prefix('courses')->name('courses.')->group(function () {
            Route::get('/', CourseListController::class)
                ->name('index');
            Route::post('/', CourseCreateController::class)
                ->name('store');
            Route::get('{id}', CourseShowController::class)
                ->whereNumber('id')
                ->name('show');
            Route::put('{id}', CourseUpdateController::class)
                ->whereNumber('id')
                ->name('update');
        });

        Route::prefix('modules')->name('modules.')->group(function () {
            Route::post('/', ModuleCreateController::class)
                ->name('store');
            Route::get('{id}', ModuleShowController::class)
                ->whereNumber('id')
                ->name('show');
            Route::put('{id}', ModuleUpdateController::class)
                ->whereNumber('id')
                ->name('update');
        });

        Route::prefix('lessons')->name('lessons.')->group(function () {
            Route::post('/', LessonCreateController::class)
                ->name('store');
            Route::get('{id}', LessonShowController::class)
                ->whereNumber('id')
                ->name('show');
            Route::put('{id}', LessonUpdateController::class)
                ->whereNumber('id')
                ->name('update');
            Route::delete('{id}', LessonDeleteController::class)
                ->whereNumber('id')
                ->name('delete');
        });

        Route::prefix('quizzes')->name('quizzes.')->group(function () {
            Route::post('/', QuizCreateController::class)
                ->name('store');
            Route::get('{uuid}', QuizDetailsController::class)
                ->whereUlid('uuid')
                ->name('show');
            Route::put('{uuid}', QuizUpdateController::class)
                ->whereUlid('uuid')
                ->name('update');
        });

        Route::prefix('questionGroups')->name('questionGroups.')->group(function () {
            Route::post('/', QuestionsGroupCreateController::class)
                ->name('store');
            Route::get('{uuid}', QuestionsGroupDetailsController::class)
                ->whereUlid('uuid')
                ->name('show');
            Route::put('{uuid}', QuestionsGroupUpdateController::class)
                ->whereUlid('uuid')
                ->name('update');
        });

        Route::prefix('questions')->name('questions.')->group(function () {
            Route::post('/', QuestionCreateController::class)
                ->name('store');
            Route::patch('{uuid}/answer', QuestionAnswerPatchController::class)
                ->whereUlid('uuid')
                ->name('patch');
        });
    });
