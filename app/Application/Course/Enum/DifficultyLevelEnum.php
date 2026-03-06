<?php
declare(strict_types=1);

namespace App\Application\Course\Enum;

enum DifficultyLevelEnum: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Expert = 'expert';
}
