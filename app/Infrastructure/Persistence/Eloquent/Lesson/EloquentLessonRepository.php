<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Lesson;

use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Models\LMS\Lesson;

class EloquentLessonRepository implements LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson
    {
        return Lesson::find($id);
    }

    public function save(array $data): Lesson
    {
        return Lesson::create($data);
    }

    public function update(Lesson $lesson, array $data): Lesson
    {
        $lesson->update($data);

        return $lesson;
    }

    public function delete(Lesson $lesson): void
    {
        $lesson->delete();
    }
}
