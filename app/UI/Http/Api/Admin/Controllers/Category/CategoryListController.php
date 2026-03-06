<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Category;

use App\Application\Category\Queries\CategoryListQuery;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\Category\CategoryListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryListController extends Controller
{
    public function __construct(
        private readonly CategoryListQuery $query
    ) {}

    public function __invoke(): AnonymousResourceCollection
    {
        $categories = $this->query->handle();

        return CategoryListItemResource::collection($categories);
    }
}
