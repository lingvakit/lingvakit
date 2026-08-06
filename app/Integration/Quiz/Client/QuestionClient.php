<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Application\Quiz\Dto\QuestionsGroup\Request\Question\QuestionAnswerCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto;
use App\Integration\Quiz\Dto\Response\QuestionDto;
use App\Integration\Quiz\Mapper\QuestionMapper;

class QuestionClient extends BaseClient implements QuestionsServiceInterface
{
    public function __construct(
        private readonly QuestionMapper $mapper
    ) {}

    public function create(
        QuestionCreateDto $requestDto
    ): QuestionDto {
        $response = $this->http()->post(
            url: "{$this->getMsUrl()}/api/v1/questions",
            data: $requestDto->convertToArray()
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }

    public function patchCorrectAnswer(
        string $questionUuid,
        QuestionAnswerCreateDto $requestDto
    ): QuestionDto {
        $response = $this->http()->patch(
            url: "{$this->getMsUrl()}/api/v1/questions/{$questionUuid}/answer",
            data: $requestDto->convertToArray()
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }
}
