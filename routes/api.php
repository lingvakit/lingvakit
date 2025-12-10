<?php

use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('v1/courses', [CourseController::class, 'index']);
Route::get('v1/courses/{id}', [CourseController::class, 'show']);
Route::post('v1/courses/{courseId}/modules/{moduleId}/quizzes/create', [QuizController::class, 'createQuiz']);
