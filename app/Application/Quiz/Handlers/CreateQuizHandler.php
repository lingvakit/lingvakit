<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;
use App\Application\Quiz\Mapper\QuizMapper;
use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Client\QuizClient;
use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;
use App\Integration\Quiz\Exception\QuizCreateFailedException;
use Illuminate\Database\DatabaseManager;

final readonly class CreateQuizHandler implements CreateQuizHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private TopicRepositoryInterface $topicRepository,
        private QuizClient $quizClient,
        private QuizMapper $quizMapper
    ) {
    }

    public function handle(QuizCreateRequestDto $dto): QuizDto
    {
        return $this->db->transaction(function () use ($dto) {
            try {
                $responseDto = $this->quizClient->create($dto);
            } catch (QuizCreateFailedException $e) {
                throw new QuizCreateFailedException(
                    message: 'Failed to create quiz',
                    previous: $e->getPrevious()
                );
            }

            $this->topicRepository->save(
                $this->prepareTopicEntity($dto)
            );

            return $this->quizMapper->fromMsResponse($responseDto);
        });
    }

    private function prepareTopicEntity(QuizCreateRequestDto $dto): TopicEntity
    {
        return new TopicEntity(
            id: null,
            entityId: $dto->uuid,
            orderIndex: $dto->orderIndex,
            type: TopicTypeEnum::Quiz,
            moduleId: $dto->moduleId,
            passedTopics: $dto->passedTopics,
        );
    }
}
