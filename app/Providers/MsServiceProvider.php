<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\QuizMigrate\Handlers\BooleanHandler;
use App\Console\Commands\QuizMigrate\Handlers\FillInBlankHandler;
use App\Console\Commands\QuizMigrate\Handlers\FreeTextHandler;
use App\Console\Commands\QuizMigrate\Handlers\MatchHandler;
use App\Console\Commands\QuizMigrate\Handlers\MultipleChoiceHandler;
use App\Console\Commands\QuizMigrate\Handlers\SentenceBuildHandler;
use App\Console\Commands\QuizMigrate\Handlers\SingleChoiceHandler;
use App\Console\Commands\QuizMigrate\QuestionPayloadBuilder;
use App\Infrastructure\Auth\JwtService;
use App\Infrastructure\MS\Media\MediaClient;
use App\Infrastructure\MS\Quiz\Clients\QuestionClient;
use App\Infrastructure\MS\Quiz\Clients\QuestionGroupClient;
use App\Infrastructure\MS\Quiz\Clients\QuizClient;
use App\Infrastructure\MS\Quiz\QuizMsClientFactory;
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
        $this->app->singleton(QuizMsClientFactory::class);

        $this->app->singleton(
            abstract: QuizClient::class,
            concrete: fn($app) => $app
                ->make(QuizMsClientFactory::class)
                ->make(QuizClient::class),
        );

        $this->app->singleton(
            abstract: QuestionGroupClient::class,
            concrete: fn($app) => $app
                ->make(QuizMsClientFactory::class)
                ->make(QuestionGroupClient::class),
        );

        $this->app->singleton(
            abstract: QuestionClient::class,
            concrete: fn($app) => $app
                ->make(QuizMsClientFactory::class)
                ->make(QuestionClient::class),
        );

        $this->app->singleton(QuestionPayloadBuilder::class, function ($app) {
            return new QuestionPayloadBuilder([
                $app->make(SingleChoiceHandler::class),
                $app->make(MultipleChoiceHandler::class),
                $app->make(BooleanHandler::class),
                $app->make(FillInBlankHandler::class),
                $app->make(MatchHandler::class),
                $app->make(FreeTextHandler::class),
                $app->make(SentenceBuildHandler::class),
            ]);
        });
    }
}
