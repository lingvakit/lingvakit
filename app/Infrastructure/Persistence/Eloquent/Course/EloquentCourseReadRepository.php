<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Course;

use App\Application\Course\Dto\CourseDetailsDto;
use App\Application\Course\Dto\CourseListItemDto;
use App\Application\Course\ReadModel\CourseReadRepository;
use App\Models\LMS\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\AbstractPaginator;

class EloquentCourseReadRepository implements CourseReadRepository
{
    public function paginate(int $perPage, string $search): AbstractPaginator
    {
        $query = Course::query()
            ->select([
                'id',
                'image',
                'title',
                'created_at'
            ])
            ->orderByDesc('id');

        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->paginate($perPage)->through(
            fn(Course $course) => new CourseListItemDto(
                id: $course->id,
                title: $course->title,
                imageUrl: $course->getImage(),
                createdAt: $course->created_at->toISOString(),
            )
        );
    }

    public function getById(int $id): CourseDetailsDto
    {
        $course = Course::query()
            ->select([
                'id',
                'image',
                'title',
                'duration',
                'author_id',
                'description',
                'created_at'
            ])
            ->with(['author', 'stages'])
            ->whereKey($id)
            ->first();

        if (!$course) {
            throw new ModelNotFoundException("Course {$id} not found");
        }

        return new CourseDetailsDto(
            id: $course->id,
            title: $course->title,
            price: $course->getPrice(),
            duration: (int)$course->duration,
            createdAt: $course->created_at->toISOString(),
            description: $course->description ?? null,
            imageUrl: $course->getImage(),
            author: $course->author->getFullName(),
            modules: $course->stages->map(fn($stage) => [
                'id' => $stage->id,
                'title' => $stage->name,
                'topics' => $stage->topics->map(fn($topic) => [
                    'id' => $topic->id,
                    'title' => $topic->getTitle(),
                    'type' => $topic->getType(),
                    'imageUrl' => $topic->getImageUrl(),
                    'sortIndex' => $topic->index_number ?? null,
                    'requiredTopics' => $this->getRequiredTopics($topic->passed_topics),
                    'description' => "",
                    'duration' => 10,
                ])
            ])->values()->all(),
        );
    }

    private function getRequiredTopics(string $passedTopics = null): ?array
    {
        return $passedTopics
            ? array_map(
                callback: 'intval',
                array: explode(',', $passedTopics)
            ) : null;
    }
}
