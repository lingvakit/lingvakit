<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Lesson;

use App\Application\Lesson\Commands\CreateLessonHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Lesson\LessonCreateRequest;
use App\UI\Http\Api\Admin\Resources\Lesson\LessonDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LessonCreateController extends Controller
{
    public function __construct(
        private readonly CreateLessonHandlerInterface $handler
    ) {
    }

    public function __invoke(LessonCreateRequest $request): JsonResponse
    {
        $lesson = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            data: [
                'data' => new LessonDetailsResource($lesson)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
