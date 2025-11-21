<?php

declare(strict_types=1);

namespace App\Providers;

use App\Infrastructure\Auth\JwtService;
use App\Infrastructure\MS\Media\MediaClient;
use App\Infrastructure\MS\Quiz\QuizClient;
use Illuminate\Support\ServiceProvider;

class MsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /** MS Media */
        $this->app->singleton(MediaClient::class, function () {
            return new MediaClient(
                baseUrl: config('app.url') . config('services.ms.media'),
                token: app()->make(JwtService::class)->getJwtToken(),
            );
        });

        /** MS Quiz */
        $this->app->singleton(QuizClient::class, function () {
            return new QuizClient(
                baseUrl: config('app.url') . config('services.ms.quiz'),
                token: app()->make(JwtService::class)->getJwtToken(),
            );
        });
    }
}
