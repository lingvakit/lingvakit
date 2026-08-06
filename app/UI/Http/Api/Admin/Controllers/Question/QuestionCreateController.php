<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Question;

use App\Application\Quiz\Handlers\Question\CreateQuestionHandlerInterface;
use App\UI\Http\Api\Admin\Requests\Question\QuestionRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuestionResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class QuestionCreateController
{
    public function __construct(
        private CreateQuestionHandlerInterface $handler
    ) {}

    public function __invoke(QuestionRequest $request): JsonResponse
    {
        $dto = $this->handler->handle(
            $request->dto()
        );

        return response()->json(
            new QuestionResource($dto),
            status: Response::HTTP_CREATED
        );
    }
}
