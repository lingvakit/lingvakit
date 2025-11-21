<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Media\Repositories\MediaRepository;
use App\Models\MediaFile;
use Illuminate\Support\Collection;

class MediaRepositoryEloquent implements MediaRepository
{
    public function getAllByType(string $type): Collection
    {
        return MediaFile::where('type', $type)->latest()->get();
    }

    public function find(int $id): ?MediaFile
    {
        return MediaFile::find($id);
    }
}
