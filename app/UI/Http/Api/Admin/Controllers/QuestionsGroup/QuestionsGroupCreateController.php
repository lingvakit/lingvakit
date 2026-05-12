<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\QuestionsGroup;

use App\Application\Quiz\Handlers\CreateQuestionsGroupHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\QuestionsGroup\QuestionsGroupRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuestionsGroupResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionsGroupCreateController extends Controller
{
    public function __construct(
        private readonly CreateQuestionsGroupHandlerInterface $handler
    ) {
    }

    /**
     * TODO: Create unit tests for the endpoint
     */
    public function __invoke(QuestionsGroupRequest $request): JsonResponse
    {
        $questionsGroupDto = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            data: [
                'data' => new QuestionsGroupResource($questionsGroupDto)
            ],
            status: Response::HTTP_CREATED
        );
    }
}
