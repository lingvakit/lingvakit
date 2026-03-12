<?php
declare(strict_types=1);

namespace App\Application\Media\Queries;

use App\Application\Media\ReadModel\MediaFileRepository;
use Illuminate\Pagination\AbstractPaginator;

final readonly class MediaFileListQuery
{
    public function __construct(
        private MediaFileRepository $repository
    ) {}

    public function handle(int $perPage, string $search): AbstractPaginator
    {
        return $this->repository->paginate($perPage, $search);
    }
}
