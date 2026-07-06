<?php
declare(strict_types=1);

namespace App\Domain\Module\Entity;

class ModuleEntity
{
    public function __construct(
        private readonly int $id,
        private string $title,
    ) {}
}
