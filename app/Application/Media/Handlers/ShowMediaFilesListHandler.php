<?php
declare(strict_types=1);

namespace App\Application\Media\Handlers;

use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use Illuminate\Pagination\AbstractPaginator;

final readonly class ShowMediaFilesListHandler implements ShowMediaFilesListHandlerInterface
{
    public function __construct(
        private MediaFileRepositoryInterface $repository
    ) {
    }

    public function handle(int $perPage, string $search, string $type): AbstractPaginator
    {
        return $this->repository->paginate($perPage, $search, $type);
    }
}
