<?php
declare(strict_types=1);

namespace App\Application\Quiz\UseCase;

use App\Application\Quiz\Mapper\QuestionsGroupMapper;
use App\Application\Quiz\Mapper\QuizMapper;
use App\Domain\Quiz\Entity\QuizEntity;
use App\Domain\Quiz\Repository\LegacyQuestionGroupRepositoryInterface;
use App\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Client\QuestionsGroupClient;
use App\Integration\Quiz\Client\QuizClient;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;

readonly class MigrateQuizDataUseCase
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private QuizRepositoryInterface $quizRepository,
        private LegacyQuestionGroupRepositoryInterface $groupRepository,
        private QuizClient $quizClient,
        private QuestionsGroupClient $questionGroupClient,
        private QuizMapper $quizMapper,
        private QuestionsGroupMapper $questionsGroupMapper,
        private LoggerInterface $logger,
    ) {
    }

    public function execute(int $batchSize, int $offset = 0): array
    {
        /** @var QuizEntity[] $legacyQuizzes */
        $legacyQuizzes = $this->quizRepository->getQuizzesChunk($batchSize, $offset);

        if (empty($legacyQuizzes)) {
            return [
                'processed' => 0,
                'failed' => 0
            ];
        }

        $processedCount = 0;
        $failedCount = 0;

        foreach ($legacyQuizzes as $legacyQuiz) {
            try {
                $quizCreateRequestDto = $this->quizMapper->toMsPayload($legacyQuiz);
                $this->quizClient->create($quizCreateRequestDto);

                $quizUuid = $quizCreateRequestDto->uuid;
                $this->topicRepository->updateEntityId(
                    topicId: $legacyQuiz->getTopicId(),
                    quizUuid: $quizUuid->toRfc4122()
                );

                $questionGroups = $this->groupRepository->getGroupsForQuiz(
                    $legacyQuiz->getId()
                );

                foreach ($questionGroups as $questionGroup) {
                    $questionGroupRequestDto = $this->questionsGroupMapper->toMsPayload(
                        $questionGroup,
                        $quizUuid
                    );

                    $this->questionGroupClient->create($questionGroupRequestDto);
                }

                $processedCount++;
            } catch (\Throwable $e) {
                $this->logger->error("Ошибка миграции квиза ID {$legacyQuiz->getId()}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                continue;
            }
        }

        DB::connection('mysql')->flushQueryLog();
        gc_collect_cycles();

        return [
            'processed' => $processedCount,
            'failed' => $failedCount,
        ];
    }
}
