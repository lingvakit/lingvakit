<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use App\Application\Quiz\Mapper\QuestionsGroupMapper;
use App\Integration\Quiz\Client\QuestionsGroupClient;
use App\Integration\Quiz\Exception\QuestionsGroupCreateFailedException;

final readonly class CreateQuestionsGroupHandler implements CreateQuestionsGroupHandlerInterface
{
    public function __construct(
        private QuestionsGroupClient $client,
        private QuestionsGroupMapper $mapper
    ) {
    }

    public function handle(QuestionsGroupCreateDto $requestDto): QuestionsGroupDto
    {
        try {
            $responseDto = $this->client->create($requestDto);
        } catch (QuestionsGroupCreateFailedException $e) {
            throw new QuestionsGroupCreateFailedException(
                message: "Failed to create questions group",
                previous: $e->getPrevious(),
            );
        }

        return $this->mapper->fromMsResponse($responseDto);
    }
}
