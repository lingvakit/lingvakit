<?php
declare(strict_types = 1);

namespace App\Domain\Quiz\Enum;

enum QuestionFontSizeEnum: string
{
    case Normal = 'normal';
    case Large = 'large';
    case Huge = 'huge';
}
