<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CourseDto;
use App\Application\Course\Dto\CourseUpdateRequestDto;

interface UpdateCourseHandlerInterface
{
    public function handle(int $courseId, CourseUpdateRequestDto $dto): CourseDto;
}
