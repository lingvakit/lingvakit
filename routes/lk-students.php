<?php
declare(strict_types=1);

use App\Http\Controllers\Admin\HomeWorkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserResultController;
use App\Http\Controllers\UserTopicController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('learning')->middleware(['auth', 'locale'])->group(function (){
    // Profile Update
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile.show');
    Route::put('/profile/user-update', [UserController::class, 'infoUpdate'])->name('user-info.update');
    Route::put('/profile/user-password-update', [UserController::class, 'passwordUpdate'])->name('user-password.update');
    // Settings of site
    Route::get('/settings', [SettingController::class, 'studentShow'])->name('user-settings');
    Route::put('/settings', [SettingController::class, 'update'])->name('user-settings.update');


    Route::get('my-courses', [SiteController::class, 'myCourses'])->name('site.my-courses');

    Route::prefix('courses/course-{course}')->group(function (){

        Route::post('get-course', [SiteController::class, 'getCourse'])->name('site.get-course');

        /* Topics */
        Route::prefix('topic-{topic}')->group(function (){

            Route::get('/', [UserTopicController::class, 'showTopic'])->name('site.show-topic');
            Route::post('homework/send', [HomeWorkController::class, 'storeHomeWork'])->name('site.homework.send');
            /* Lessons */
            Route::prefix('lesson-{lesson}')->group(function (){
//                Route::get('/', [UserTopicController::class, 'showLesson'])->name('site.lesson-show');
                Route::post('/', [UserTopicController::class, 'passed'])->name('site.lesson-passed');
            });
            /* Quizzes */
            Route::prefix('quiz-{quiz}')->group(function (){
//                Route::get('/', [UserTopicController::class, 'showQuiz'])->name('site.quiz-show');
                Route::post('leave-comment', [UserTopicController::class, 'leaveComment'])->name('site.quiz.leave-comment');
                Route::get('testing', [UserTopicController::class, 'testing'])->name('site.testing');
                Route::post('result', [UserResultController::class, 'store'])->name('site.store-results');
                /* Work on Bugs */
                Route::get('bug-work', [UserTopicController::class, 'bugWork'])->name('bug-work.show');
            });
        });

        // Reviews
        Route::post('review', [SiteController::class, 'storeReview'])->name('course.reviews.store');

        /* ORDERING */
        /* Checkout */
//        Route::get('cart', [OrderController::class, 'shoppingCart'])->name('orders.cart');
        Route::get('checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
        Route::post('checkout', [OrderController::class, 'storeOrder'])->name('orders.store');
        Route::get('order-noty', [OrderController::class, 'notification'])->name('orders.noty');
    });

    Route::get('payment-info', [OrderController::class, 'paymentResult'])->name('orders.payment-info');
});