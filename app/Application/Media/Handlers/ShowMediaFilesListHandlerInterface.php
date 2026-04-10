<?php
declare(strict_types=1);

namespace App\Application\Media\Handlers;

use Illuminate\Pagination\AbstractPaginator;

interface ShowMediaFilesListHandlerInterface
{
    public function handle(int $perPage, string $search, string $type): AbstractPaginator;
}
