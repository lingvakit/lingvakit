<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Topic;

use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use App\Models\LMS\Topic;

class EloquentTopicRepository implements TopicRepositoryInterface
{
    public function save(array $data): Topic
    {
        return Topic::create($data);
    }
}
