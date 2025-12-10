<?php

declare(strict_types=1);

namespace App\Domain\Course\Handlers;

use App\Domain\Course\Repositories\CourseRepository;
use App\Models\LMS\Course;

final readonly class CourseHandler
{
    public function __construct(
        private CourseRepository $courseRepository
    ) {
    }

    public function getAll(string $sortBy = 'title', string $orderBy = 'ASC', int $perPage = 10, $page = 1): array
    {
        $paginator = $this->courseRepository->filterByField($sortBy, $orderBy, $perPage, $page);

        $mappedCourses = $paginator->getCollection()->map(function (Course $course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'duration' => $course->getDuration(),
                'publishDate' => $course->publish_date,
                'imageUrl' => $course->getImage(),
            ];
        });

        return $paginator->setCollection($mappedCourses)->toArray();
    }

    public function getById(int $id): array
    {
        $course = $this->courseRepository->findByIdWithModules($id);
        $modules = [];

        foreach ($course->stages ?? [] as $stage) {
            $module = [
                'id' => $stage->id,
                'title' => $stage->name,
                'topics' => []
            ];

            foreach ($stage->topics ?? [] as $topic) {
                $content = $topic->lesson ?: $topic->quiz;

                if ($content) {
                    $module['topics'][] = [
                        'title' => $content->title,
                        'description' => $content->description,
                        'imageUrl' => $content->getImage(),
                        'timeLimit' => $content->getDuration(),
                        'type' => $topic->lesson ? 'lesson' : 'quiz',
                    ];
                }
            }

            $modules[] = $module;
        }

        return [
            'id' => $id,
            'title' => $course->title,
            'description' => $course->description,
            'imageUrl' => $course->getImage(),
            'duration' => $course->getDuration(),
            'publishDate' => $course->publish_date,
            'price' => $course->getPrice(),
            'category' => $course->category ? __($course->category->name) : null,
            'language' => $course->language ? __("languages.".$course->language->label) : null,
            'difficultyLevel' => __("cms-pages.".$course->difficulty_level),
            'author' => [
                'fullName' => $course->author->getFullName()
            ],
            'modules' => $modules,
        ];
    }
}