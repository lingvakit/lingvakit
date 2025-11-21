<?php

declare(strict_types=1);

namespace App\Domain\Category\Repositories;

use App\Models\LMS\Category;
use Illuminate\Support\Collection;

interface CategoryRepository
{
    public function allExceptUncategorized(): Collection;
    public function find(int $id): ?Category;
}
