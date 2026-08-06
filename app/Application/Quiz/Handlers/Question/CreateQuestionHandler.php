<?php
declare( strict_types = 1 );

namespace App\Application\Quiz\Handlers\Question;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto;
use App\Application\Quiz\Mapper\QuestionMapper;
use App\Integration\Quiz\Client\QuestionClient;
use App\Integration\Quiz\Exception\QuestionCreateFailedException;

final readonly class CreateQuestionHandler implements CreateQuestionHandlerInterface
{
    public function __construct(
        private QuestionClient $client,
        private QuestionMapper $mapper
    ) {
    }

    public function handle(QuestionCreateDto $requestDto): QuestionDto
    {
        try {
            $responseDto = $this->client->create($requestDto);
        } catch (QuestionCreateFailedException $e) {
            throw new QuestionCreateFailedException(
                message: "Failed to create question",
                previous: $e->getPrevious(),
            );
        }

        return $this->mapper->fromMsResponse($responseDto);
    }
}
