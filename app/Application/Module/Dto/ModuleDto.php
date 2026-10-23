<?php
declare(strict_types=1);

namespace App\Application\Module\Dto;

use App\Application\Course\Dto\Course\CourseTopicDto;

final class ModuleDto
{
    /**
     * @param list<CourseTopicDto> $topics
     */
    public function __construct(
        public int $id,
        public string $title,
        public array $topics = [],
    ) {
    }
}
