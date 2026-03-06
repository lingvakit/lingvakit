<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Category;

use App\Application\Category\Dto\CategoryListItemDto;
use App\Application\Category\ReadModel\CategoryReadRepository;
use App\Models\LMS\Category;
use Illuminate\Support\Collection;

class EloquentCategoryReadRepository implements CategoryReadRepository
{
    public function getList(): Collection
    {
        return Category::query()
            ->select(['id', 'name'])
            ->where('name', '!=', 'Uncategorized')
            ->orderBy('name')
            ->get()
            ->map(fn($row) => new CategoryListItemDto(
                id: $row->id,
                title: $row->name
            ));
    }
}
