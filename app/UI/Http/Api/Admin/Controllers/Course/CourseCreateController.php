<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Commands\CreateCourseHandler;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseCreateRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseCreateController extends Controller
{
    public function __construct(
        private readonly CreateCourseHandler $handler
    ) {
    }

    public function __invoke(CourseCreateRequest $request): JsonResponse
    {
        $id = $this->handler->handle(
            dto: $request->dto(),
            authorId: auth()->user()->id
        );

        return response()->json(
            data: ['data' => ['id' => $id]],
            status: Response::HTTP_CREATED
        );
    }
}
