<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionGroup;

readonly class MetaDto
{
    public function __construct(
        private ?array $style = null
    ) {}

    public function getStyle(): ?array
    {
        return $this->style;
    }
}