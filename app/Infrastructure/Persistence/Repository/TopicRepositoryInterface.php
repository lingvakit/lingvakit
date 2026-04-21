<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Topic;

interface TopicRepositoryInterface
{
    public function findById(int $id): ?Topic;
    public function findByEntityId(string $entityId): ?Topic;
    public function save(array $data): Topic;
    public function update(Topic $topic, array $data): Topic;
    public function delete(Topic $topic): void;
}
