<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Commands\UpdateLessonHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Lesson\LessonUpdateRequest;
use App\UI\Http\Api\Admin\Resources\Lesson\LessonDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonUpdateController extends Controller
{
    public function __construct(
        private readonly UpdateLessonHandlerInterface $handler
    ) {
    }

    public function __invoke(
        LessonUpdateRequest $request,
        int $lessonId
    ): JsonResponse {
        $lesson = $this->handler->handle($lessonId, $request->dto());

        return response()->json(
            data: [
                'data' => new LessonDetailsResource($lesson)
            ],
            status: Response::HTTP_OK
        );
    }
}
