<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Course\Dto\CreateCourseDto;
use App\Models\LMS\Course;
use DB;

class CourseRepository
{
    public function create(CreateCourseDto $dto, int $authorId): int
    {
        return DB::transaction(function () use ($dto, $authorId) {
            $course = new Course();
            $course->title = $dto->getTitle();
            $course->description = $dto->getDescription();
            $course->difficulty_level = $dto->getDifficultyLevel()->value;
            $course->price = $dto->getPrice();
            $course->duration = $dto->getDuration();
            $course->category_id = $dto->getCategoryId();
            $course->image = $dto->getImageId();
            $course->video = $dto->getVideoId();
            $course->author_id = $authorId;

            $course->save();

            return $course->id;
        });
    }
}
