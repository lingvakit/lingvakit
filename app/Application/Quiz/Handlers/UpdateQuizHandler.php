<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;
use App\Application\Quiz\Mapper\QuizMapper;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Client\QuizClient;
use App\Integration\Quiz\Dto\Request\Quiz\QuizUpdateRequestDto;
use App\Integration\Quiz\Exception\QuizUpdateFailedException;
use App\Kafka\Exception\TopicNotFoundException;
use Illuminate\Database\DatabaseManager;

final readonly class UpdateQuizHandler implements UpdateQuizHandlerInterface
{
    public function __construct(
        private DatabaseManager $db,
        private QuizClient $quizClient,
        private TopicRepositoryInterface $topicRepository,
        private QuizMapper $quizMapper
    ) {}

    public function handle(string $quizUuid, QuizUpdateRequestDto $dto): QuizDto
    {
        return $this->db->transaction(function () use ($quizUuid, $dto) {
            try {
                $responseDto = $this->quizClient->update($quizUuid, $dto);
            } catch (QuizUpdateFailedException $e) {
                throw new QuizUpdateFailedException(
                    message: 'Failed to update quiz',
                    previous: $e->getPrevious()
                );
            }

            $this->updateTopic($quizUuid);

            return $this->quizMapper->fromMsResponse($responseDto);
        });
    }

    private function updateTopic(string $entityId): void
    {
        $topicEntity = $this->topicRepository->findByEntityId($entityId);
        if (!$topicEntity) {
            throw new TopicNotFoundException("Topic with entityId '{$entityId}' not found");
        }

        $orderIndex = $dto->orderIndex ?? $topicEntity->getOrderIndex();
        $passedTopics = $dto->passedTopics ?? $topicEntity->getPassedTopics();

        $topicEntity
            ->setOrderIndex($orderIndex)
            ->setPassedTopics($passedTopics);

        $this->topicRepository->update($topicEntity);
    }
}
