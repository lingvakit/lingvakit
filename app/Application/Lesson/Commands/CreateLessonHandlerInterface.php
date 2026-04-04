<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonCreateRequestDto;

interface CreateLessonHandlerInterface
{
    public function handle(LessonCreateRequestDto $dto): int;
}
