<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Commands\UpdateLessonHandler;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Lesson\LessonUpdateRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonUpdateController extends Controller
{
    public function __construct(
        private UpdateLessonHandler $handler
    ) {
    }

    public function __invoke(LessonUpdateRequest $request, int $lessonId): JsonResponse
    {
        $this->handler->handle(
            $lessonId,
            $request->dto()
        );

        return response()->json(
            ['data' => ['id' => $lessonId]],
            Response::HTTP_CREATED
        );
    }
}
