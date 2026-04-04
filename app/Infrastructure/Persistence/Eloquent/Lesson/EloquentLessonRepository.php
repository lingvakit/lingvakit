<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Lesson;

use App\Infrastructure\Persistence\Repository\LessonRepositoryInterface;
use App\Models\LMS\Lesson;

/**
 * TODO: findById and update methods will be done
 */
class EloquentLessonRepository implements LessonRepositoryInterface
{
//    public function findById(int $id): ?Stage
//    {
//        return Stage::find($id);
//    }

    public function save(array $data): Lesson
    {
        return Lesson::create($data);
    }

//    public function update(Stage $stage, array $data): Stage
//    {
//        $stage->update($data);
//
//        return $stage;
//    }
}