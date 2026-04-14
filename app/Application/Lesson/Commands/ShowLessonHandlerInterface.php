<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

use App\Application\Lesson\Dto\LessonDto;

interface ShowLessonHandlerInterface
{
    public function handle(int $lessonId): LessonDto;
}
