<?php
declare(strict_types=1);

namespace App\Application\Module\Dto;

class RequestUpdateModuleDto
{
    public function __construct(
        public string $title
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->title
        ];
    }
}
