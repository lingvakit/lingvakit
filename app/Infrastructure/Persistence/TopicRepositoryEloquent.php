<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Topic\Repositories\TopicRepository;
use App\Models\LMS\Topic;

class TopicRepositoryEloquent implements TopicRepository
{
    public function find(int $id): ?Topic
    {
        return Topic::find($id);
    }

    public function delete(int $id): void
    {
        $this->find($id)?->delete();
    }
}
