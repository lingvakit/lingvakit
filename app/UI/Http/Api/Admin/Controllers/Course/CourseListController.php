<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Course;

use App\Application\Course\Queries\CourseListQuery;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Course\CourseListRequest;
use App\UI\Http\Api\Admin\Resources\Course\CourseListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class CourseListController extends Controller
{
    public function __construct(
        private readonly CourseListQuery $query
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
