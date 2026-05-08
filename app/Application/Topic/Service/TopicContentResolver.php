<?php
declare(strict_types=1);

namespace App\Application\Topic\Service;

use App\Application\Topic\Dto\TopicDto;
use App\Application\Topic\Mapper\TopicLessonMapper;
use App\Application\Topic\Mapper\TopicQuizMapper;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Exceptions\TopicNotExistsException;
use App\Infrastructure\Persistence\Repository\TopicRepositoryInterface;
use App\Integration\Quiz\Client\QuizClient;
use App\Models\LMS\Topic;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Uid\Uuid;

readonly class TopicContentResolver
{
    public function __construct(
        private TopicRepositoryInterface $repository,
        private TopicLessonMapper $lessonMapper,
        private TopicQuizMapper $quizMapper,
        private QuizClient $quizClient,
    ) {
    }

    public function resolveContent(int $topicId): TopicDto
    {
        $topic = $this->repository->findById($topicId);

        if ($topic === null) {
            throw new TopicNotExistsException(
                message: "Topic with id {$topicId} not found"
            );
        }

        if ($topic->name === TopicTypeEnum::Quiz->value) {
            return $this->getTopicQuizDto($topic);
        }

        return $this->lessonMapper->fromModel($topic);
    }

    private function getTopicQuizDto(Topic $topic): TopicDto
    {
        if ($topic->entity_id === null || !Uuid::isValid($topic->entity_id)) {
            throw new BadRequestHttpException(
                "UUID [$topic->entity_id] is invalid."
            );
        }

        $quizResponseDto = $this->quizClient->getDataByUuid(
            $topic->entity_id
        );

        return $this->quizMapper->fromModel($topic, $quizResponseDto);
    }
}
