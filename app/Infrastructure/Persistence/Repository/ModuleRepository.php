<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Module\Dto\RequestModuleDto;
use App\Models\LMS\Stage;
use DB;

class ModuleRepository
{
    public function create(int $courseId, RequestModuleDto $dto): Stage
    {
        return DB::transaction(function () use ($courseId, $dto) {
            $module = new Stage();
            $module->name = $dto->title;
            $module->course_id = $courseId;
            $module->save();

            return $module;
        });
    }

    public function update(Stage $module, RequestModuleDto $dto): Stage
    {
        return DB::transaction(function () use ($module, $dto) {
            $module->name = $dto->title;
            $module->save();

            return $module;
        });
    }
}
