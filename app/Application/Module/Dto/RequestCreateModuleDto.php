<?php
declare(strict_types=1);

namespace App\Application\Module\Dto;

class RequestCreateModuleDto
{
    public function __construct(
        public int $courseId,
        public string $title
    ) {
    }

    public function toArray(): array
    {
        return [
            'course_id' => $this->courseId,
            'name' => $this->title
        ];
    }
}
