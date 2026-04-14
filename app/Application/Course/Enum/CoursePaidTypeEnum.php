<?php
declare(strict_types=1);

namespace App\Application\Course\Enum;

enum CoursePaidTypeEnum: string
{
    case Free = 'free';
    case Paid = 'paid';
}
