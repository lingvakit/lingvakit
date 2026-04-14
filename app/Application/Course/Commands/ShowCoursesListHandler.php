<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CourseListItemDto;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use App\Models\LMS\Course;
use Illuminate\Pagination\AbstractPaginator;

final readonly class ShowCoursesListHandler implements ShowCoursesListHandlerInterface
{
    public function __construct(
        private CourseRepositoryInterface $repository
    ) {}

    public function handle(int $itemsPerPage, string $search): AbstractPaginator
    {
        $paginatedCourses = $this->repository->paginate($itemsPerPage, $search);

        return $paginatedCourses->through(
            fn(Course $course) => new CourseListItemDto(
                id: $course->id,
                title: $course->title,
                imageUrl: $course->getImage(),
                createdAt: $course->created_at->toImmutable(),
            )
        );
    }
}
