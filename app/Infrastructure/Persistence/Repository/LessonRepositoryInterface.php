<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Lesson;

interface LessonRepositoryInterface
{
    public function findById(int $id): ?Lesson;
    public function save(array $data): Lesson;
    public function update(Lesson $lesson, array $data): Lesson;
    public function delete(Lesson $lesson): void;
}
