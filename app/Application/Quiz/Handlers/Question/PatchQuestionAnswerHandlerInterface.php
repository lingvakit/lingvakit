<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\Question;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;

interface PatchQuestionAnswerHandlerInterface
{
    public function handle(
        string $questionUuid,
        QuestionAnswerCreateDto $requestDto
    ): QuestionDto;
}
