<?php
declare(strict_types = 1);

namespace App\Domain\Quiz\Enum;

enum QuestionTypeEnum: string
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case Boolean = 'boolean';
    case FillInBlank = 'fill_in_blank';
    case Match = 'match';
    case SentenceBuild = 'sentence_build';
    case FreeText = 'free_text';
}
