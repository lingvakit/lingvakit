<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CourseDto;

interface ShowCourseHandlerInterface
{
    public function handle(int $courseId): CourseDto;
}
