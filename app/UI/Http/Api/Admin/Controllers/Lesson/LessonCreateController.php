<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Commands\CreateLessonHandler;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Lesson\LessonCreateRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonCreateController extends Controller
{
    public function __construct(
        private readonly CreateLessonHandler $handler
    ) {
    }

    public function __invoke(LessonCreateRequest $request): JsonResponse
    {
        $lessonId = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            ['data' => ['id' => $lessonId]],
            Response::HTTP_CREATED
        );
    }
}
