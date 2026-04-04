<?php

namespace App\UI\Http\Api\Admin\Controllers\Module;

use App\Application\Module\Commands\ShowModuleHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Resources\Module\ModuleDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleShowController extends Controller
{
    public function __construct(
        private readonly ShowModuleHandlerInterface $handler
    ) {
    }

    public function __invoke(int $moduleId): JsonResponse
    {
        $module = $this->handler->handle($moduleId);

        return response()->json(
            data: [
                'data' => new ModuleDetailsResource($module)
            ],
            status: Response::HTTP_OK
        );
    }
}
