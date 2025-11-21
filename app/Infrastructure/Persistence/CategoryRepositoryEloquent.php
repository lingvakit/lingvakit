<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Category\Repositories\CategoryRepository;
use App\Models\LMS\Category;
use Illuminate\Support\Collection;

class CategoryRepositoryEloquent implements CategoryRepository
{
    public function allExceptUncategorized(): Collection
    {
        return Category::where('name', '!=', 'Uncategorized')->get();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }
}
