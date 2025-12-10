<?php

namespace App\Http\Controllers\Api;

use App\Application\Quiz\Actions\CreateAction as QuizCreateAction;
use App\Domain\Course\Repositories\CourseRepository;
use App\Domain\Quiz\Repositories\ModuleRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

final class QuizController extends Controller
{
    public function __construct(
        private readonly CourseRepository $courseRepository,
        private readonly ModuleRepository $moduleRepository,
        private readonly QuizCreateAction $quizCreateAction,
    ) {}

    public function createQuiz(StoreQuizRequest $request, int $courseId, int $moduleId): JsonResponse
    {
        $course = $this->courseRepository->findById($courseId);
        $module = $this->moduleRepository->findById($moduleId);

        DB::transaction(function () use ($request, $course, $module) {
            return $this->quizCreateAction->execute(
                data: $request->validated(),
                course: $course,
                stage: $module
            );
        });

        return response()->json(['message' => 'Ok'], Response::HTTP_CREATED);
    }
}
