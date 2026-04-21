<?php
declare(strict_types=1);

namespace App\Domain\Course\Enum;

enum DifficultyLevelEnum: string
{
    case Beginner = 'beginner';
    case Intermediate = 'intermediate';
    case Expert = 'expert';
}
