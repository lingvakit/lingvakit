<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Mapper\QuizMapper;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\QuizDto;
use App\Integration\Quiz\Exception\QuizCreateFailedException;
use App\Integration\Quiz\QuizClient;
use Illuminate\Support\Facades\DB;

final readonly class CreateQuizHandler implements CreateQuizHandlerInterface
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private QuizClient $quizClient,
        private QuizMapper $quizMapper
    ) {
    }

    public function handle(QuizCreateRequestDto $dto): QuizDto
    {
        return DB::transaction(function () use ($dto) {
            try {
                $responseDto = $this->quizClient->create($dto);
            } catch (QuizCreateFailedException $e) {
                throw new QuizCreateFailedException(
                    message: 'Failed to create quiz',
                    previous: $e->getPrevious()
                );
            }

            $this->topicRepository->save(
                $dto->convertToArrayForTopic()
            );

            return $this->quizMapper->fromMsResponse($responseDto);
        });
    }
}
