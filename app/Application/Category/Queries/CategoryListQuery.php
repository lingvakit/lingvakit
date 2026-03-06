<?php
declare(strict_types=1);

namespace App\Application\Category\Queries;

use App\Application\Category\ReadModel\CategoryReadRepository;
use Illuminate\Support\Collection;

final readonly class CategoryListQuery
{
    public function __construct(
        private CategoryReadRepository $repository
    ) {}

    public function handle(): Collection
    {
        return $this->repository->getList();
    }
}
