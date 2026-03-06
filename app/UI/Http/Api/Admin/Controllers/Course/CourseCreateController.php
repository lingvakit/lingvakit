<?php
declare (strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Commands\CreateCourseCommand;
use App\Application\Course\Commands\CreateCourseHandler;
use App\Application\Course\Enum\DifficultyLevelEnum;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseCreateRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseCreateController extends Controller
{
    public function __construct(
        private readonly CreateCourseHandler $handler
    ) {}

    public function __invoke(CourseCreateRequest $request): JsonResponse
    {
        $data = $request->dto();

        $id = $this->handler->handle(new CreateCourseCommand(
            title: $data['title'],
            description: $data['description'] ?? null,
            difficultyLevel: DifficultyLevelEnum::from($data['difficulty_level']),
            price: $data['price'],
            duration: $data['duration'],
            imageId: $data['image'],
        ));

        return response()->json(
            data: ['data' => ['id' => $id]],
            status: Response::HTTP_CREATED
        );
    }
}
