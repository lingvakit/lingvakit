<?php
declare(strict_types=1);

use App\UI\Http\Api\Admin\Controllers\Category\CategoryListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseCreateController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseListController;
use App\UI\Http\Api\Admin\Controllers\Course\CourseShowController;
use App\UI\Http\Api\Admin\Controllers\Media\MediaFileListController;

// React admin
Route::middleware(['web'])->prefix('react/api')->group(function () {
    Route::get('categories', CategoryListController::class);

    Route::get('courses', CourseListController::class);
    Route::post('courses', CourseCreateController::class);
    Route::get('courses/{id}', CourseShowController::class);

    Route::get('media', MediaFileListController::class)
        ->name('admin.react.media.list');
});