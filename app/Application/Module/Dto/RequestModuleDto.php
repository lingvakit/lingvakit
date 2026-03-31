<?php
declare(strict_types=1);

namespace App\Application\Module\Dto;

class RequestModuleDto
{
    public function __construct(
        public string $title
    ) {}
}
