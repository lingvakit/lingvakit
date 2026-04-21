<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Enum;

enum QuizStatusEnum: string
{
    case Deleted = 'deleted';
    case Draft = 'draft';
    case Published = 'published';
}
