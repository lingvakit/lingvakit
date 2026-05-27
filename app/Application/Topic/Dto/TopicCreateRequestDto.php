<?php
declare(strict_types=1);

namespace App\Application\Topic\Dto;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;

class TopicCreateRequestDto
{
    public function __construct(
        public int $moduleId,
        public TopicTypeEnum $type,
        public ?int $orderIndex = null,
        public ?LessonCreateRequestDto $lesson = null,
        public ?QuizCreateRequestDto $quiz = null,
    ) {}
}
