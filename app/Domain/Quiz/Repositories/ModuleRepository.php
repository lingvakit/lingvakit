<?php

declare(strict_types=1);

namespace App\Domain\Quiz\Repositories;

use App\Models\LMS\Stage;

interface ModuleRepository
{
    public function findById(int $id): ?Stage;
}
