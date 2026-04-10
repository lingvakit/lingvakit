<?php
declare(strict_types=1);

namespace App\Providers;

use App\Application\Category\ReadModel\CategoryReadRepository;
use App\Infrastructure\Persistence\Eloquent\Category\EloquentCategoryReadRepository;
use App\Infrastructure\Persistence\Eloquent\Course\EloquentCourseRepository;
use App\Infrastructure\Persistence\Eloquent\Lesson\EloquentLessonRepository;
use App\Infrastructure\Persistence\Eloquent\MediaFile\EloquentMediaFileRepository;
use App\Infrastructure\Persistence\Eloquent\Module\EloquentModuleRepository;
use App\Infrastructure\Persistence\Eloquent\Topic\EloquentTopicRepository;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: MediaFileRepositoryInterface::class,
            concrete: EloquentMediaFileRepository::class
        );

        $this->app->bind(
            abstract: CategoryReadRepository::class,
            concrete: EloquentCategoryReadRepository::class
        );

        $this->app->bind(
            abstract: CourseRepositoryInterface::class,
            concrete: EloquentCourseRepository::class
        );

        $this->app->bind(
            abstract: ModuleRepositoryInterface::class,
            concrete: EloquentModuleRepository::class
        );

        $this->app->bind(
            abstract: TopicRepositoryInterface::class,
            concrete: EloquentTopicRepository::class
        );

        $this->app->bind(
            abstract: LessonRepositoryInterface::class,
            concrete: EloquentLessonRepository::class
        );
    }
}
