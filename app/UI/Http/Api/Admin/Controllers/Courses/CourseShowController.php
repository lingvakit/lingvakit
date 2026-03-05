<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Courses;

use App\Application\Courses\Queries\GetCourseQuery;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\CourseDetailsResource;

final class CourseShowController extends Controller
{
    public function __construct(
        private readonly GetCourseQuery $query
    ) {}

    public function __invoke(int $courseId): CourseDetailsResource
    {
        $course = $this->query->handle($courseId);

        return new CourseDetailsResource($course);
    }
}
