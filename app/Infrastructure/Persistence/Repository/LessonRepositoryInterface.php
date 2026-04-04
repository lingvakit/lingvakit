<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Models\LMS\Lesson;

/**
 * TODO: methods findById and update
 */
interface LessonRepositoryInterface
{
//    public function findById(int $id): ?Stage;
    public function save(array $data): Lesson;
//    public function update(Stage $stage, array $data): Stage;
}
