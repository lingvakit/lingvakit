<?php
declare(strict_types=1);

namespace App\Application\Module\Handlers;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Module\Dto\RequestCreateModuleDto;
use App\Infrastructure\Persistence\Repository\ModuleRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class CreateModuleHandler implements CreateModuleHandlerInterface
{
    public function __construct(
        private ModuleRepositoryInterface $repository,
    ) {}

    public function handle(RequestCreateModuleDto $dto): ModuleDto
    {
        return DB::transaction(function () use ($dto) {
            $stage = $this->repository->save(
                $dto->toArray()
            );

            return new ModuleDto(
                id: $stage->id,
                title: $stage->name,
                topics: null,
            );
        });
    }
}
