<?php
declare(strict_types=1);

namespace App\Application\Topic\Service;

use App\Application\Topic\Dto\TopicDto;
use App\Application\Topic\Mapper\TopicMapper;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Exceptions\TopicNotExistsException;
use App\Integration\Quiz\Client\QuizClient;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class TopicContentResolver
{
    public function __construct(
        private TopicRepositoryInterface $topicRepository,
        private LessonRepositoryInterface $lessonRepository,
        private QuizRepositoryInterface $quizRepository,
        private TopicMapper $topicMapper,
        private QuizClient $quizClient,
    ) {
    }

    /**
     * @throws TopicNotExistsException
     * @throws \Exception
     */
    public function resolveContent(int $topicId): TopicDto
    {
        $topic = $this->topicRepository->findById($topicId);

        if ($topic === null) {
            throw new TopicNotExistsException(
                message: "Topic with id {$topicId} not found"
            );
        }

        if ($topic->getEntityId()) {
            return $this->getTopicQuizDtoFromMs($topic);
        }

        return $this->topicMapper->fromEntity(
            topic: $topic,
            lesson: $this->lessonRepository->findByTopicId($topic->getId()),
            quiz: $this->quizRepository->findByTopicId($topic->getId()),
        );
    }

    private function getTopicQuizDtoFromMs(TopicEntity $topic): TopicDto
    {
        if ($topic->getEntityId() === null) {
            throw new BadRequestHttpException(
                "UUID [{$topic->getEntityId()->toRfc4122()}] is invalid."
            );
        }

        $quizResponseDto = $this->quizClient->getDataByUuid(
            $topic->getEntityId()->toRfc4122()
        );

        return $this->topicMapper->fromMs($topic, $quizResponseDto);
    }
}
