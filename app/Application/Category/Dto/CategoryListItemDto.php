<?php
declare(strict_types=1);

namespace App\Application\Category\Dto;

final readonly class CategoryListItemDto
{
    public function __construct(
        private int $id,
        private string $title,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
