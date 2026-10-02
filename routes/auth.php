<?php
declare(strict_types=1);

use App\UI\Http\Api\Auth\Controllers\RegisterController;

Route::middleware('guest')->group(function (): void {
    $authRoutes = [
        'login' => '/login',
        'register' => '/register',
        'password.request' => '/forgot-password',
        'password.reset' => '/reset-password/{token}',
    ];

    foreach ($authRoutes as $name => $uri) {
        Route::view($uri, 'spa.auth')->name($name);
    }

    Route::post('/register', RegisterController::class)
        ->middleware('throttle:register')
        ->name('register.store');
});