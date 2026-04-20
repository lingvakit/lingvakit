<?php
declare(strict_types=1);

namespace App\Domain\Topic\Enum;

enum TopicTypeEnum: string
{
    case Lesson = 'lesson';
    case Quiz = 'quiz';
}
