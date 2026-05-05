<?php
declare(strict_types = 1);

namespace App\Domain\Quiz\Enum;

enum QuestionTypeEnum: string
{
    case SingleChoice = 'single_choice';
}
