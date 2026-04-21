<?php
declare(strict_types=1);

namespace App\Application\Topic\Dto;

use App\Application\Lesson\Dto\LessonDto;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Integration\Quiz\Dto\QuizDto;

class TopicDto
{
    public function __construct(
        public int $id,
        public TopicTypeEnum $type,
        public ?int $orderIndex = null,
        public ?LessonDto $lesson = null,
        public ?QuizDto $quiz = null,
    ) {
    }
}
