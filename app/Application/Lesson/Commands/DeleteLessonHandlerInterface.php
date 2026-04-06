<?php
declare(strict_types=1);

namespace App\Application\Lesson\Commands;

interface DeleteLessonHandlerInterface
{
    public function handle(int $lessonId): void;
}
