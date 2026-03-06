<?php
declare(strict_types=1);

namespace App\Application\Category\ReadModel;

use App\Application\Category\Dto\CategoryListItemDto;
use Illuminate\Support\Collection;

interface CategoryReadRepository
{
    /** @return Collection<int, CategoryListItemDto> */
    public function getList(): Collection;
}