<?php
declare(strict_types=1);

namespace App\Application\Course\Mapper;

use App\Application\Course\Dto\CourseDto;
use App\Application\Module\Mapper\ModuleMapper;
use App\Models\LMS\Course;
use App\Models\LMS\Stage;

final readonly class CourseMapper
{
    public function __construct(
        private ModuleMapper $moduleMapper,
    ) {
    }

    public function fromModel(Course $course, array $lessons, array $quizzes): CourseDto
    {
        return new CourseDto(
            id: $course->id,
            title: $course->title,
            price: $course->price,
            duration: (int)$course->duration,
            category: $course->category->name,
            createdAt: $course->created_at->toImmutable(),
            description: $course->description,
            imageUrl: $course->getImage(),
            author: $course->author->getFullName(),
            modules: $course->stages
                ->map(
                    fn(Stage $stage) => $this->moduleMapper->fromModel($stage, $lessons, $quizzes)
                )->toArray(),
        );
    }
}
