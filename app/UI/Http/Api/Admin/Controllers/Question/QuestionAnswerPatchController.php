<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Question;

use App\Application\Quiz\Handlers\Question\PatchQuestionAnswerHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\Question\QuestionAnswerPatchRequest;
use App\UI\Http\Api\Admin\Resources\Quiz\QuestionResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionAnswerPatchController extends Controller
{
    public function __construct(
        private readonly PatchQuestionAnswerHandlerInterface $handler
    ) {
    }

    public function __invoke(string $questionUuid, QuestionAnswerPatchRequest $payload): JsonResponse
    {
        $question = $this->handler->handle(
            $questionUuid,
            $payload->dto(),
        );

        return response()->json(
            data: new QuestionResource($question),
            status: Response::HTTP_OK
        );
    }
}
