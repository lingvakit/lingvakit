<?php
declare(strict_types=1);

namespace App\Application\Module\Commands;

use App\Application\Module\Dto\ModuleDto;
use App\Exceptions\ModuleNotExistsException;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class ShowModuleHandler implements ShowModuleHandlerInterface
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
    ) {}

    public function handle(int $moduleId): ModuleDto
    {
        return DB::transaction(function () use ($moduleId) {
            $stage = $this->repository->findById($moduleId);

            if ($stage === null) {
                throw new ModuleNotExistsException(
                    message: "Stage with id {$moduleId} not found"
                );
            }

            return new ModuleDto(
                id: $stage->id,
                title: $stage->name,
                topics: null,
            );
        });
    }
}
