<?php
declare(strict_types=1);

namespace App\Domain\Topic\Repository;

use App\Domain\Topic\Entity\TopicEntity;

interface TopicRepositoryInterface
{
    public function findById(int $id): ?TopicEntity;
    public function findByEntityId(string $entityId): ?TopicEntity;
    public function save(TopicEntity $topic): TopicEntity;
    public function update(TopicEntity $topic): TopicEntity;
    public function updateEntityId(int $topicId, string $quizUuid): void;
    public function delete(int $id): void;
}
