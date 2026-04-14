<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Stage;

interface ModuleRepositoryInterface
{
    public function findById(int $id): ?Stage;
    public function save(array $data): Stage;
    public function update(Stage $stage, array $data): Stage;
}
