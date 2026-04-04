<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Topic;

interface TopicRepositoryInterface
{
    public function save(array $data): Topic;
}
