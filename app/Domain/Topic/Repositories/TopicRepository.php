<?php

declare(strict_types=1);

namespace App\Domain\Topic\Repositories;

use App\Models\LMS\Topic;

interface TopicRepository
{
    public function find(int $id): ?Topic;
    public function delete(int $id): void;
}
