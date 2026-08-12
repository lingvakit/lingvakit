<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupUpdateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use App\Application\Quiz\Mapper\QuestionsGroupMapper;
use App\Integration\Quiz\Client\QuestionsGroupClient;
use App\Integration\Quiz\Exception\QuestionsGroupException;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

readonly class UpdateQuestionsGroupHandler implements UpdateQuestionsGroupHandlerInterface
{
    public function __construct(
        private QuestionsGroupClient $client,
        private QuestionsGroupMapper $mapper
    ) {
    }

    public function handle(string $uuid, QuestionsGroupUpdateDto $requestDto): QuestionsGroupDto
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidArgumentException(
                sprintf('UUID "%s" invalid.', $uuid)
            );
        }

        try {
            $responseDto = $this->client->update($uuid, $requestDto);
        } catch (QuestionsGroupException $e) {
            throw new QuestionsGroupException(
                message: sprintf('Failed to update questions group with UUID "%s"', $uuid),
                previous: $e->getPrevious(),
            );
        }

        return $this->mapper->fromMsResponse($responseDto);
    }
}
