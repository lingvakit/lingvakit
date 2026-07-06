<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Enum;

enum QuestionOptionMatchSideEnum: string
{
    case Left = 'left';
    case Right = 'right';
}
