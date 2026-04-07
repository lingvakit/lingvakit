<?php
declare(strict_types=1);

namespace App\Providers;

use App\Application\Course\Commands\CreateCourseHandler;
use App\Application\Course\Commands\CreateCourseHandlerInterface;
use App\Application\Course\Commands\ShowCourseHandler;
use App\Application\Course\Commands\ShowCourseHandlerInterface;
use App\Application\Course\Commands\ShowCoursesListHandler;
use App\Application\Course\Commands\ShowCoursesListHandlerInterface;
use App\Application\Course\Commands\UpdateCourseHandler;
use App\Application\Course\Commands\UpdateCourseHandlerInterface;
use App\Application\Lesson\Commands\CreateLessonHandler;
use App\Application\Lesson\Commands\CreateLessonHandlerInterface;
use App\Application\Lesson\Commands\DeleteLessonHandler;
use App\Application\Lesson\Commands\DeleteLessonHandlerInterface;
use App\Application\Lesson\Commands\ShowLessonHandler;
use App\Application\Lesson\Commands\ShowLessonHandlerInterface;
use App\Application\Lesson\Commands\UpdateLessonHandler;
use App\Application\Lesson\Commands\UpdateLessonHandlerInterface;
use App\Application\Module\Commands\CreateModuleHandler;
use App\Application\Module\Commands\CreateModuleHandlerInterface;
use App\Application\Module\Commands\ShowModuleHandler;
use App\Application\Module\Commands\ShowModuleHandlerInterface;
use App\Application\Module\Commands\UpdateModuleHandler;
use App\Application\Module\Commands\UpdateModuleHandlerInterface;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: CreateCourseHandlerInterface::class,
            concrete: CreateCourseHandler::class
        );

        $this->app->bind(
            abstract: UpdateCourseHandlerInterface::class,
            concrete: UpdateCourseHandler::class
        );

        $this->app->bind(
            abstract: ShowCourseHandlerInterface::class,
            concrete: ShowCourseHandler::class
        );

        $this->app->bind(
            abstract: ShowCoursesListHandlerInterface::class,
            concrete: ShowCoursesListHandler::class
        );

        $this->app->bind(
            abstract: CreateModuleHandlerInterface::class,
            concrete: CreateModuleHandler::class
        );

        $this->app->bind(
            abstract: UpdateModuleHandlerInterface::class,
            concrete: UpdateModuleHandler::class
        );

        $this->app->bind(
            abstract: ShowModuleHandlerInterface::class,
            concrete: ShowModuleHandler::class
        );

        $this->app->bind(
            abstract: CreateLessonHandlerInterface::class,
            concrete: CreateLessonHandler::class
        );

        $this->app->bind(
            abstract: UpdateLessonHandlerInterface::class,
            concrete: UpdateLessonHandler::class
        );

        $this->app->bind(
            abstract: ShowLessonHandlerInterface::class,
            concrete: ShowLessonHandler::class
        );

        $this->app->bind(
            abstract: DeleteLessonHandlerInterface::class,
            concrete: DeleteLessonHandler::class
        );
    }
}
