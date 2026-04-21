<?php
declare(strict_types=1);

namespace App\Domain\Course\Enum;

enum CoursePaidTypeEnum: string
{
    case Free = 'free';
    case Paid = 'paid';
}
