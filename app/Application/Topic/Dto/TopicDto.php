<?php
declare(strict_types=1);

namespace App\Application\Topic\Dto;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Topic\Enum\TopicTypeEnum;

class TopicDto
{
    public function __construct(
        public int $id,
        public TopicTypeEnum $type,
        public ?int $orderIndex = null,
        public ?LessonDto $lesson = null,
    ) {
    }
}
