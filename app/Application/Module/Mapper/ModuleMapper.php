<?php
declare(strict_types=1);

namespace App\Application\Module\Mapper;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Topic\Service\TopicContentResolver;
use App\Models\LMS\Stage;
use App\Models\LMS\Topic;
use Symfony\Component\Uid\Uuid;

final readonly class ModuleMapper
{
    public function __construct(
        private TopicContentResolver $topicResolver,
    ) {
    }

    /**
     * TODO: Remove $quizzes param after all of quizzes will be migrated to microservice
     */
    public function fromModel(
        Stage $stage,
        array $lessons,
        array $quizzes, // TODO: Remove this
        array $msQuizzes
    ): ModuleDto {
        $validTopics = $stage->topics->filter(function (Topic $topic) use ($lessons, $quizzes, $msQuizzes) {
            $hasLesson = isset($lessons[$topic->id]);
            $hasQuiz = isset($quizzes[$topic->id]);

            $hasMsQuiz = false;
            if ($topic->entity_id !== null) {
                $normalizedUuid = Uuid::fromString((string) $topic->entity_id)->toRfc4122();
                $hasMsQuiz = isset($msQuizzes[$normalizedUuid]);
            }

            return $hasLesson || $hasQuiz || $hasMsQuiz;
        });

        return new ModuleDto(
            id: $stage->id,
            title: $stage->name,
            topics: $validTopics
                ->map(fn(Topic $topic) => $this->topicResolver->resolveContent(
                    topic: $topic,
                    lessonsLookUp: $lessons,
                    quizzesLookUp: $quizzes,
                    msQuizzesLookUp: $msQuizzes
                ))->toArray()
        );
    }
}
