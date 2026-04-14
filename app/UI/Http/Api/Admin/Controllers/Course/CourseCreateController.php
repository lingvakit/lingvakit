<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Commands\CreateCourseHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseCreateRequest;
use App\UI\Http\Api\Admin\Resources\Course\CourseDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseCreateController extends Controller
{
    public function __construct(
        private readonly CreateCourseHandlerInterface $handler
    ) {
    }

    public function __invoke(CourseCreateRequest $request): JsonResponse
    {
        $courseDto = $this->handler->handle($request->dto());

        return response()->json(
            data: ['data' => new CourseDetailsResource($courseDto)],
            status: Response::HTTP_CREATED
        );
    }
}
