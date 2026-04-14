<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonDto;
use App\Application\Lesson\Dto\LessonUpdateRequestDto;

interface UpdateLessonHandlerInterface
{
    public function handle(int $lessonId, LessonUpdateRequestDto $dto): LessonDto;
}
