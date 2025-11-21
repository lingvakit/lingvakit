<?php

declare(strict_types=1);

namespace App\Domain\Quiz\Services;

use App\Models\LMS\Category;

class CategoryService
{
    private const int UNCATEGORIZED_ID = 1;

    public function resolve(array $data): Category
    {
        $categoryId = isset($data['category_id']) ? (int)$data['category_id'] : null;

        if ($categoryId !== null) {
            if ($categoryId === 0) {
                $categoryName = $data['category'] ?? '';
                $categoryName = trim($categoryName);

                if ($categoryName === "") {
                    throw new \InvalidArgumentException("Category name can not be empty");
                }

                return Category::create(['name' => $categoryName]);
            }

            return Category::findOrFail($categoryId);
        }

        return Category::find(self::UNCATEGORIZED_ID);
    }
}
