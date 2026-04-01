<?php
declare(strict_types=1);

namespace App\Application\Course\Enum;

enum TopicTypeEnum: string
{
    case Lesson = 'lesson';
    case Quiz = 'quiz';
}
