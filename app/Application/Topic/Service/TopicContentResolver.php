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
use App\Models\LMS\Topic;
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
     * TODO: Remove param $quizzesLookUp after quizzes will be transferred to microservice
     *
     * @throws TopicNotExistsException
     * @throws \Exception
     */
    public function resolveContent(
        Topic $topic,
        array $lessonsLookUp = [],
        array $quizzesLookUp = [], // TODO: Remove this
        array $msQuizzesLookUp = [],
    ): TopicDto {
        $topicEntity = $this->topicMapper->fromModel($topic);

        if ($topicEntity->getEntityId()) {
            return $this->getTopicQuizDtoFromMs($topicEntity);
        }

        $topicId = $topic->id;
        $topicEntityId = $topic->entity_id;

        $lessonEntity = $lessonsLookUp[$topicId] ?? null;
        $quizEntity = $quizzesLookUp[$topicId] ?? null;

        if ($topicEntityId) {
            $quizEntity = $msQuizzesLookUp[$topicEntityId] ?? null;
        }

        return $this->topicMapper->fromEntity(
            topic: $topicEntity,
            lesson: $lessonEntity,
            quiz: $quizEntity,
        );
    }

    private function getTopicQuizDtoFromMs(TopicEntity $topic): TopicDto
    {
        if ($topic->getEntityId() === null) {
            throw new BadRequestHttpException(
                "UUID is invalid."
            );
        }

        $quizResponseDto = $this->quizClient->getDataByUuid(
            $topic->getEntityId()->toRfc4122()
        );

        return $this->topicMapper->fromMs($topic, $quizResponseDto);
    }
}
