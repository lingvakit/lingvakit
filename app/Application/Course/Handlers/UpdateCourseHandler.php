<?php
declare(strict_types=1);

namespace App\Application\Course\Handlers;

use App\Application\Course\Dto\CourseDto;
use App\Application\Course\Dto\CourseUpdateRequestDto;
use App\Application\Course\Mapper\CourseMapper;
use App\Exceptions\CourseNotExistsException;
use App\Infrastructure\Persistence\Repository\CourseRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class UpdateCourseHandler implements UpdateCourseHandlerInterface
{
    public function __construct(
        private CourseRepositoryInterface $repository,
        private CourseMapper $courseMapper,
    ) {
    }

    public function handle(int $courseId, CourseUpdateRequestDto $dto): CourseDto
    {
        return DB::transaction(function () use ($courseId, $dto) {
            $course = $this->repository->findById($courseId);

            if ($course === null) {
                throw new CourseNotExistsException(
                    message: "Course with id {$courseId} does not found."
                );
            }

            $this->repository->update(
                course: $course,
                data: $dto->toArray()
            );

            return $this->courseMapper->fromModel($course);
        });
    }
}
