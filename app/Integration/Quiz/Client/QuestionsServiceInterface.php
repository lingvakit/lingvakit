<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Integration\Quiz\Dto\Response\QuestionDto;

interface QuestionsServiceInterface
{
    public function patchCorrectAnswer(
        string $questionUuid,
        QuestionAnswerCreateDto $requestDto
    ): QuestionDto;
}
