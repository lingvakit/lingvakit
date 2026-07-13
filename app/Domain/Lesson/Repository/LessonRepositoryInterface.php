<?php
declare(strict_types=1);

namespace App\Domain\Lesson\Repository;

use App\Domain\Lesson\Entity\LessonEntity;

interface LessonRepositoryInterface
{
    public function findById(int $id): ?LessonEntity;
    public function findByTopicId(int $topicId): ?LessonEntity;

    /**
     * @param int[] $topicIds
     * @return array<int, LessonEntity>
     */
    public function findByTopicIds(array $topicIds): array;

    public function save(LessonEntity $lesson): LessonEntity;
    public function update(LessonEntity $lesson): LessonEntity;
    public function delete(int $id): void;
}
