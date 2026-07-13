<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Lesson;

use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Trait\LessonDatabaseMapperTrait;
use App\Models\LMS\Lesson;

class EloquentLessonRepository implements LessonRepositoryInterface
{
    use LessonDatabaseMapperTrait;

    public function findById(int $id): ?LessonEntity
    {
        $lesson = Lesson::find($id);

        return $lesson ? $this->mapToEntity($lesson) : null;
    }

    public function findByTopicId(int $topicId): ?LessonEntity
    {
        $lesson = Lesson::where('topic_id', $topicId)->first();

        return $lesson ? $this->mapToEntity($lesson) : null;
    }

    public function findByTopicIds(array $topicIds): array
    {
        if (empty($topicIds)) {
            return [];
        }

        $lessons = Lesson::whereIn('topic_id', $topicIds)->get();

        $result = [];
        foreach ($lessons as $lesson) {
            $result[(int)$lesson->topic_id] = $this->mapToEntity($lesson);
        }

        return $result;
    }

    public function save(LessonEntity $lesson): LessonEntity
    {
        $data = $this->mapToArray($lesson);
        $lessonModel = Lesson::create($data);

        return $this->mapToEntity($lessonModel);
    }

    public function update(LessonEntity $lesson): LessonEntity
    {
        $data = $this->mapToArray($lesson);
        Lesson::find($lesson->getId())?->update($data);

        return $lesson;
    }

    public function delete(int $id): void
    {
        Lesson::find($id)?->delete();
    }
}
