<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Handlers\UpdateCourseHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseUpdateRequest;
use App\UI\Http\Api\Admin\Resources\Course\CourseDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseUpdateController extends Controller
{
    public function __construct(
        private readonly UpdateCourseHandlerInterface $handler
    ) {
    }

    public function __invoke(
        CourseUpdateRequest $request,
        int $courseId
    ): JsonResponse {
        $courseDto = $this->handler->handle($courseId, $request->dto());

        return response()->json(
            data: ['data' => new CourseDetailsResource($courseDto)],
            status: Response::HTTP_CREATED
        );
    }
}
