<?php

namespace App\UI\Http\Api\Admin\Controllers\Module;

use App\Application\Module\Commands\CreateModuleHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Module\ModuleCreateRequest;
use App\UI\Http\Api\Admin\Resources\Module\ModuleDetailsResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ModuleCreateController extends Controller
{
    public function __construct(
        private readonly CreateModuleHandlerInterface $handler
    ) {}

    public function __invoke(
        ModuleCreateRequest $request
    ): JsonResponse {
        $module = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            data: [
                'data' => new ModuleDetailsResource($module)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
