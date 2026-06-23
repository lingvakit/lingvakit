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
use Illuminate\Support\Facades\DB;

final readonly class UpdateQuizHandler implements UpdateQuizHandlerInterface
{
    public function __construct(
        private QuizClient $quizClient,
        private TopicRepositoryInterface $topicRepository,
        private QuizMapper $quizMapper
    ) {}

    public function handle(string $quizUuid, QuizUpdateRequestDto $dto): QuizDto
    {
        return DB::transaction(function () use ($quizUuid, $dto) {
            try {
                $responseDto = $this->quizClient->update($quizUuid, $dto);
            } catch (QuizUpdateFailedException $e) {
                throw new QuizUpdateFailedException(
                    message: 'Failed to update quiz',
                    previous: $e->getPrevious()
                );
            }

            $topic = $this->topicRepository->findByEntityId($quizUuid);
            if (!$topic) {
                throw new TopicNotFoundException("Topic with entityId '{$quizUuid}' not found");
            }

            $this->topicRepository->update(
                $topic, $dto->convertToArrayForTopic()
            );

            return $this->quizMapper->fromMsResponse($responseDto);
        });
    }
}
