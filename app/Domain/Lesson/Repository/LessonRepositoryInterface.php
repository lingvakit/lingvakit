<?php
declare(strict_types=1);

namespace App\Domain\Lesson\Repository;

use App\Domain\Lesson\Entity\LessonEntity;

interface LessonRepositoryInterface
{
    public function findById(int $id): ?LessonEntity;
    public function findByTopicId(int $topicId): ?LessonEntity;
    public function save(LessonEntity $lesson): LessonEntity;
    public function update(LessonEntity $lesson): LessonEntity;
    public function delete(int $id): void;
}
