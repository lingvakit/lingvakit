<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CourseDto;
use App\Application\Course\Mapper\CourseMapper;
use App\Exceptions\CourseNotExistsException;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class ShowCourseHandler implements ShowCourseHandlerInterface
{
    public function __construct(
        private CourseRepositoryInterface $repository,
        private CourseMapper $mapper
    ) {}

    public function handle(int $courseId): CourseDto
    {
        return DB::transaction(function () use ($courseId) {
            $course = $this->repository->findById($courseId);

            if ($course === null) {
                throw new CourseNotExistsException(
                    message: "Course with id {$courseId} not found"
                );
            }

            return $this->mapper->fromModel($course);
        });
    }
}
