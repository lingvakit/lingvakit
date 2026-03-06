<?php
declare(strict_types=1);

namespace App\Application\Course\Commands;

use App\Models\LMS\Course;
use DB;

class CreateCourseHandler
{
    public function handle(CreateCourseCommand $command): int
    {
        return DB::transaction(function () use ($command) {
            $course = new Course();
            $course->title = $command->title;
            $course->description = $command->description;
            $course->difficulty_level = $command->difficultyLevel->value;
            $course->price = $command->price;
            $course->duration = $command->duration;
            $course->image = $command->imageId;
            $course->author_id = auth()->user()->id;
            $course->save();

            return (int)$course->id;
        });
    }
}
