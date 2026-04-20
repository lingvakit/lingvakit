<?php
declare(strict_types=1);

namespace App\Application\Lesson\Handlers;

use App\Application\Lesson\Dto\LessonCreateRequestDto;
use App\Application\Lesson\Dto\LessonDto;

interface CreateLessonHandlerInterface
{
    public function handle(LessonCreateRequestDto $dto): LessonDto;
}
