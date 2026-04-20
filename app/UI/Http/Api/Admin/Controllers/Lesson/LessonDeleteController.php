<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Handlers\DeleteLessonHandlerInterface;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonDeleteController extends Controller
{
    public function __construct(
        private readonly DeleteLessonHandlerInterface $handler
    ) {
    }

    public function __invoke(int $lessonId): JsonResponse
    {
        $this->handler->handle($lessonId);

        return response()->json(
            data: null,
            status: Response::HTTP_NO_CONTENT
        );
    }
}
