<?php
declare(strict_types=1);

use App\UI\Http\Api\Admin\Controllers\Category\CategoryListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseCreateController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseShowController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonCreateController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonDeleteController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonShowController;
use App\UI\Http\Api\Admin\Controllers\Lesson\LessonUpdateController;
use App\UI\Http\Api\Admin\Controllers\Media\MediaFileListController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleCreateController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleShowController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleUpdateController;

// React admin
// TODO: add auth middleware !!!
Route::middleware(['web'])->prefix('react/api')->group(function () {
    Route::get('categories', CategoryListController::class);

    /* courses */
    Route::prefix('courses')->group(function () {
        Route::get('/', CourseListController::class);
        Route::get('{id}', CourseShowController::class);
        Route::post('/', CourseCreateController::class);
    });

    /* modules */
    Route::prefix('modules')->group(function () {
        Route::get('{id}', ModuleShowController::class);
        Route::post('/', ModuleCreateController::class);
        Route::put('{id}', ModuleUpdateController::class);
    });

    /* lessons */
    Route::prefix('lessons')->group(function () {
        Route::get('{id}', LessonShowController::class);
        Route::post('/', LessonCreateController::class);
        Route::put('{id}', LessonUpdateController::class);
        Route::delete('{id}', LessonDeleteController::class);
    });

    Route::get('media', MediaFileListController::class)
        ->name('admin.react.media.list');
});