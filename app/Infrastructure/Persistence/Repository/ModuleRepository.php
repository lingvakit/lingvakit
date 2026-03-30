<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Module\Dto\CreateModuleDto;
use App\Models\LMS\Stage;
use DB;

class ModuleRepository
{
    public function create(int $courseId, CreateModuleDto $dto): int
    {
        return DB::transaction(function () use ($courseId, $dto) {
            $module = new Stage();
            $module->name = $dto->title;
            $module->course_id = $courseId;
            $module->save();

            return $module->id;
        });
    }
}