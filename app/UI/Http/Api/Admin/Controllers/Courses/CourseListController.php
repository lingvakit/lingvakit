<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Courses;

use App\Application\Courses\Queries\ListCoursesQuery;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Courses\CourseListRequest;
use App\UI\Http\Api\Admin\Resources\CourseListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CourseListController extends Controller
{
    public function __construct(
        private readonly ListCoursesQuery $query
    ) {}

    public function __invoke(CourseListRequest $request): AnonymousResourceCollection
    {
        $paginator = $this->query->handle(
            perPage: $request->perPage(),
            search: $request->queryString(),
        );

        return CourseListItemResource::collection($paginator);
    }
}
