<?php
declare(strict_types=1);

use App\UI\Http\Api\Admin\Controllers\Courses\CourseListController;
use App\UI\Http\Api\Admin\Controllers\Courses\CourseShowController;

Route::middleware(['web', 'auth'])->prefix('react/api')->group(function () {
    Route::get('courses', CourseListController::class);
    Route::get('courses/{id}', CourseShowController::class);
});