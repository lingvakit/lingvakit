<?php
declare(strict_types=1);

namespace App\Application\Module\Mapper;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Topic\Service\TopicContentResolver;
use App\Exceptions\TopicNotExistsException;
use App\Models\LMS\Stage;
use App\Models\LMS\Topic;
use Symfony\Component\Uid\Uuid;

final readonly class ModuleMapper
{
    public function __construct(
        private TopicContentResolver $topicResolver,
    ) {
    }

    public function fromStageSummary(Stage $stage): ModuleDto
    {
        return new ModuleDto(
            id: (int)$stage->id,
            title: (string)$stage->name,
            topics: [],
        );
    }

    /**
     * TODO: Remove $quizzes param after all of quizzes will be migrated to microservice
     *
     * @param array<int, mixed> $lessons lookup: topic_id => lesson
     * @param array<int, mixed> $quizzes lookup: topic_id => legacy quiz
     * @param array<string, mixed> $msQuizzes lookup: quiz uuid (RFC 4122) => quiz from MS
     * @throws TopicNotExistsException
     */
    public function fromModel(
        Stage $stage,
        array $lessons,
        array $quizzes, // TODO: Remove this
        array $msQuizzes,
    ): ModuleDto
    {
        $validTopics = $stage->topics->filter(
            fn(Topic $topic): bool => isset($lessons[$topic->id])
                || isset($quizzes[$topic->id])
                || $this->hasMicroserviceQuiz($topic, $msQuizzes)
        );

        return new ModuleDto(
            id: (int)$stage->id,
            title: (string)$stage->name,
            topics: $validTopics
                ->map(fn(Topic $topic) => $this->topicResolver->resolveContent(
                    topic: $topic,
                    lessonsLookUp: $lessons,
                    quizzesLookUp: $quizzes,
                    msQuizzesLookUp: $msQuizzes,
                ))
                ->values()
                ->all(),
        );
    }

    private function hasMicroserviceQuiz(Topic $topic, array $msQuizzes): bool
    {
        $entityId = (string)$topic->entity_id;

        if ($entityId === '' || !Uuid::isValid($entityId)) {
            return false;
        }

        return isset($msQuizzes[Uuid::fromString($entityId)->toRfc4122()]);
    }
}
