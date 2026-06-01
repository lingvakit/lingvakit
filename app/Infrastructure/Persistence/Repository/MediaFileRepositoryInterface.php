<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Media\Dto\MediaFileDto;
use App\Models\MediaFile;
use Illuminate\Pagination\AbstractPaginator;

interface MediaFileRepositoryInterface
{
    public function findById(int $id): ?MediaFile;
    public function findByFilenameAndPath(string $filename, string $path): ?MediaFile;
    public function save(array $data): MediaFile;

    /** @return AbstractPaginator<MediaFileDto> */
    public function paginate(int $perPage, string $search, string $type): AbstractPaginator;
}
