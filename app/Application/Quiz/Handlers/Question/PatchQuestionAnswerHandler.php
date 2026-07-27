<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\Question;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Mapper\QuestionMapper;
use App\Integration\Quiz\Client\QuestionClient;

readonly class PatchQuestionAnswerHandler implements PatchQuestionAnswerHandlerInterface
{
    public function __construct(
        private QuestionClient $questionClient,
        private QuestionMapper $questionMapper,
    ) {
    }

    public function handle(
        string $questionUuid,
        QuestionAnswerCreateDto $requestDto
    ): QuestionDto {
        $responseDto = $this->questionClient->patchCorrectAnswer($questionUuid, $requestDto);

        return $this->questionMapper->fromMsResponse($responseDto);
    }
}
