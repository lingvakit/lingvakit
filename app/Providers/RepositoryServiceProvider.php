<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Category\Repositories\CategoryRepository;
use App\Domain\Media\Repositories\MediaRepository;
use App\Domain\Quiz\Repositories\QuizRepository;
use App\Domain\Topic\Repositories\TopicRepository;
use App\Infrastructure\Persistence\CategoryRepositoryEloquent;
use App\Infrastructure\Persistence\MediaRepositoryEloquent;
use App\Infrastructure\Persistence\QuizRepositoryEloquent;
use App\Infrastructure\Persistence\TopicRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CategoryRepository::class,
            CategoryRepositoryEloquent::class
        );

        $this->app->bind(
            MediaRepository::class,
            MediaRepositoryEloquent::class
        );

        $this->app->bind(
            TopicRepository::class,
            TopicRepositoryEloquent::class
        );

        $this->app->bind(
            QuizRepository::class,
            QuizRepositoryEloquent::class
        );
    }
}
