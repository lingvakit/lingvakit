<?php
declare(strict_types=1);

namespace App\Application\Course\Handlers;

use App\Application\Course\Dto\CourseDto;

interface ShowCourseHandlerInterface
{
    public function handle(int $courseId): CourseDto;
}
