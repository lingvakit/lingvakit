<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Quiz\Repositories\ModuleRepository;
use App\Models\LMS\Stage;

class ModuleRepositoryEloquent implements ModuleRepository
{
    public function findById(int $id): ?Stage
    {
        return Stage::find($id);
    }
}