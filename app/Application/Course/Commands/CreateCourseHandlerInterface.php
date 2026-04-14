<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Application\Course\Dto\CourseCreateRequestDto;
use App\Application\Course\Dto\CourseDto;

interface CreateCourseHandlerInterface
{
    public function handle(CourseCreateRequestDto $dto): CourseDto;
}
