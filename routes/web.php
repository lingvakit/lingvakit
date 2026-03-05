<?php

use App\Http\Controllers\Admin\MediaFileController;
use App\Http\Controllers\Admin\PromocodeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\System\RepairController;
use Illuminate\Support\Facades\Route;


// посадочная test
Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/documents-list', [SiteController::class, 'documentList'])->name('site.documents-list');
Route::get('reviews', [SiteController::class, 'reviewsPage'])->name('site.reviews');


// Chats
Route::prefix('chat')->middleware(['auth'])->group(function (){
    Route::get('/', [ChatController::class, 'chatPage'])->name('chat');
    Route::get('room/user-{user}/create', [ChatController::class, 'chatRoomCreate'])->name('chat.create');
    Route::get('room/{chat}', [ChatController::class, 'chatRoom'])->name('chat.room');
    Route::post('room/user-{user}/send-message', [ChatController::class, 'sendFirstMessage'])->name('chat.store');
    Route::post('room/{chat}/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');
    Route::delete('room/{chat}', [ChatController::class, 'destroyChat'])->name('chat.destroy');
});

Route::get('learning', [SiteController::class, 'learning'])->name('site.learning');
Route::get('about-us', [SiteController::class, 'aboutUs'])->name('site.about-us');
Route::get('contacts', [SiteController::class, 'contacts'])->name('site.contacts');
Route::get('privacy-policy', [SiteController::class, 'privacyPolicy'])->name('site.privacy-policy');
Route::get('offer-agreement', [SiteController::class, 'offerAgreement'])->name('site.offer-agreement');
Route::get('contacts', [SiteController::class, 'contacts'])->name('site.contacts');
Route::get('courses/course-{course}/show', [SiteController::class, 'showCourse'])->name('site.course-show');
Route::post('feedback', [SiteController::class, 'feedback'])->name('feedback');
Route::get('rubrics/{rubricSlug}', [SiteController::class, 'articlesByRubric'])->name('site.rubric.articles');
Route::get('rubrics/{rubricSlug}/{articleSlug}', [SiteController::class, 'articlePage'])->name('site.article');

// О преподавателях: пока статика
Route::get('teachers/1', function (){
   return view('about-teacher');
})->name('app.teacher-info');

Route::post('/email/verification-notification', [AuthController::class, 'sendEmailVerificationNotification'])
    ->middleware('auth')->name('verification.send');
Route::get('/email/verify', [AuthController::class, 'verifyEmail'])
    ->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerification'])
    ->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verify/success', [AuthController::class, 'successVerification'])
    ->middleware(['auth', 'verified'])->name('verification.success');

Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

/* AJAX */
Route::get('ajax/files/{fileType}', [MediaFileController::class, 'getFilesByAjax'])->name('ajax.get-files');
Route::get('ajax/promo/{code}', [PromocodeController::class, 'getPromoCodeData'])->name('ajax.get-promo-code');


Route::middleware(['guest'])->group(function (){
    Route::post('reset-user-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Delete non-existent topics
Route::prefix('repair')->middleware(['role:superuser'])->group(function (){
    Route::get('delete-topics', [RepairController::class, 'fixTopicsDatabase'])->name('repair.delete-topics');
});

/* Students routes */
require_once 'lk-students.php';
/* Admins routes */
require_once 'admin.php';

/* React admin API */
require_once 'react-admin.php';