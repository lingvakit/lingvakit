<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Commands\ShowCoursesListHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseListRequest;
use App\UI\Http\Api\Admin\Resources\Course\CourseListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CourseListController extends Controller
{
    public function __construct(
        private readonly ShowCoursesListHandlerInterface $handler
    ) {}

    public function __invoke(CourseListRequest $request): AnonymousResourceCollection
    {
        $paginator = $this->handler->handle(
            itemsPerPage: $request->perPage(),
            search: $request->queryString(),
        );

        return CourseListItemResource::collection($paginator);
    }
}
