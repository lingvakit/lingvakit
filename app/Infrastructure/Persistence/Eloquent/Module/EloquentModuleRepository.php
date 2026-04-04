<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Module;

use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use App\Models\LMS\Stage;

class EloquentModuleRepository implements ModuleRepositoryInterface
{
    public function findById(int $id): ?Stage
    {
        return Stage::find($id);
    }

    public function save(array $data): Stage
    {
        return Stage::create($data);
    }

    public function update(Stage $stage, array $data): Stage
    {
        $stage->update($data);

        return $stage;
    }
}