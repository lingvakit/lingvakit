<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Handlers\ShowLessonHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\Lesson\LessonDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonShowController extends Controller
{
    public function __construct(
        private readonly ShowLessonHandlerInterface $handler
    ) {}

    public function __invoke(int $lessonId): JsonResponse
    {
        $lesson = $this->handler->handle($lessonId);

        return response()->json(
            data: [
                'data' => new LessonDetailsResource($lesson)
            ],
            status: Response::HTTP_OK
        );
    }
}
