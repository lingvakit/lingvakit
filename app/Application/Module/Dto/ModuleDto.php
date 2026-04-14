<?php
declare(strict_types=1);

namespace App\Application\Module\Dto;

use App\Application\Course\Dto\Course\CourseTopicDto;

final readonly class ModuleDto
{
    public function __construct(
        public int $id,
        public string $title,

        /** @var array<CourseTopicDto> */
        public ?array $topics = [],
    ) {}
}
