<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\QuestionsGroup;

use App\Application\Quiz\Handlers\QuestionsGroup\UpdateQuestionsGroupHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\QuestionsGroup\QuestionsGroupUpdateRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuestionsGroupResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionsGroupUpdateController extends Controller
{
    public function __construct(
        private readonly UpdateQuestionsGroupHandlerInterface $handler
    ) {
    }

    public function __invoke(
        QuestionsGroupUpdateRequest $request,
        string $uuid
    ): JsonResponse {
        $questionsGroupDto = $this->handler->handle(
            $uuid,
            $request->dto()
        );

        return response()->json(
            data: new QuestionsGroupResource($questionsGroupDto),
            status: Response::HTTP_OK
        );
    }
}
