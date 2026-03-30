<?php
declare(strict_types=1);

use App\UI\Http\Api\Admin\Controllers\Category\CategoryListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseCreateController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseShowController;
use App\UI\Http\Api\Admin\Controllers\Media\MediaFileListController;
use App\UI\Http\Api\Admin\Controllers\Module\ModuleCreateController;

// React admin
// TODO: add auth middleware !!!
Route::middleware(['web'])->prefix('react/api')->group(function () {
    Route::get('categories', CategoryListController::class);

    Route::prefix('courses')->group(function () {
        /* courses */
        Route::get('/', CourseListController::class);
        Route::post('/', CourseCreateController::class);
        Route::get('{id}', CourseShowController::class);

        /* course modules */
        Route::post('{id}/modules', ModuleCreateController::class);
    });


    Route::get('media', MediaFileListController::class)
        ->name('admin.react.media.list');
});