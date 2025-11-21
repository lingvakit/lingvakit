<?php

declare(strict_types=1);

namespace App\Domain\Media\Repositories;

use App\Models\MediaFile;
use Illuminate\Support\Collection;

interface MediaRepository
{
    public function getAllByType(string $type): Collection;
    public function find(int $id): ?MediaFile;
}
