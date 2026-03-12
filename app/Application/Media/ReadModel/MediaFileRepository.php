<?php
declare(strict_types=1);

namespace App\Application\Media\ReadModel;

use App\Application\Media\Dto\MediaFileDto;
use Illuminate\Pagination\AbstractPaginator;

interface MediaFileRepository
{
    /** @return AbstractPaginator<MediaFileDto> */
    public function paginate(int $perPage, string $search): AbstractPaginator;
}
