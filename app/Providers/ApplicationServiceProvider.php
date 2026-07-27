<?php
declare(strict_types=1);

namespace App\Providers;

use App\Application\Course\Handlers\CreateCourseHandler;
use App\Application\Course\Handlers\CreateCourseHandlerInterface;
use App\Application\Course\Handlers\ShowCourseHandler;
use App\Application\Course\Handlers\ShowCourseHandlerInterface;
use App\Application\Course\Handlers\ShowCoursesListHandler;
use App\Application\Course\Handlers\ShowCoursesListHandlerInterface;
use App\Application\Course\Handlers\UpdateCourseHandler;
use App\Application\Course\Handlers\UpdateCourseHandlerInterface;
use App\Application\Lesson\Handlers\CreateLessonHandler;
use App\Application\Lesson\Handlers\CreateLessonHandlerInterface;
use App\Application\Lesson\Handlers\DeleteLessonHandler;
use App\Application\Lesson\Handlers\DeleteLessonHandlerInterface;
use App\Application\Lesson\Handlers\ShowLessonHandler;
use App\Application\Lesson\Handlers\ShowLessonHandlerInterface;
use App\Application\Lesson\Handlers\UpdateLessonHandler;
use App\Application\Lesson\Handlers\UpdateLessonHandlerInterface;
use App\Application\Media\Handlers\ShowMediaFilesListHandler;
use App\Application\Media\Handlers\ShowMediaFilesListHandlerInterface;
use App\Application\Media\Handlers\UploadMediaFileHandler;
use App\Application\Media\Handlers\UploadMediaFileHandlerInterface;
use App\Application\Module\Handlers\CreateModuleHandler;
use App\Application\Module\Handlers\CreateModuleHandlerInterface;
use App\Application\Module\Handlers\ShowModuleHandler;
use App\Application\Module\Handlers\ShowModuleHandlerInterface;
use App\Application\Module\Handlers\UpdateModuleHandler;
use App\Application\Module\Handlers\UpdateModuleHandlerInterface;
use App\Application\Quiz\Handlers\CreateQuestionsGroupHandler;
use App\Application\Quiz\Handlers\CreateQuestionsGroupHandlerInterface;
use App\Application\Quiz\Handlers\CreateQuizHandler;
use App\Application\Quiz\Handlers\CreateQuizHandlerInterface;
use App\Application\Quiz\Handlers\Question\PatchQuestionAnswerHandler;
use App\Application\Quiz\Handlers\Question\PatchQuestionAnswerHandlerInterface;
use App\Application\Quiz\Handlers\QuestionsGroup\QuestionsGroupDetailsHandler;
use App\Application\Quiz\Handlers\QuestionsGroup\QuestionsGroupDetailsHandlerInterface;
use App\Application\Quiz\Handlers\QuizDetailsHandler;
use App\Application\Quiz\Handlers\QuizDetailsHandlerInterface;
use App\Application\Quiz\Handlers\UpdateQuizHandler;
use App\Application\Quiz\Handlers\UpdateQuizHandlerInterface;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: ShowMediaFilesListHandlerInterface::class,
            concrete: ShowMediaFilesListHandler::class
        );

        $this->app->bind(
            abstract: UploadMediaFileHandlerInterface::class,
            concrete: UploadMediaFileHandler::class
        );

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

        $this->app->bind(
            abstract: CreateQuizHandlerInterface::class,
            concrete: CreateQuizHandler::class
        );

        $this->app->bind(
            abstract: UpdateQuizHandlerInterface::class,
            concrete: UpdateQuizHandler::class
        );

        $this->app->bind(
            abstract: QuizDetailsHandlerInterface::class,
            concrete: QuizDetailsHandler::class
        );

        $this->app->bind(
            abstract: CreateQuestionsGroupHandlerInterface::class,
            concrete: CreateQuestionsGroupHandler::class
        );

        $this->app->bind(
            abstract: QuestionsGroupDetailsHandlerInterface::class,
            concrete: QuestionsGroupDetailsHandler::class
        );

        $this->app->bind(
            abstract: PatchQuestionAnswerHandlerInterface::class,
            concrete: PatchQuestionAnswerHandler::class
        );
    }
}
