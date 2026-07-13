<?php
declare(strict_types=1);

namespace App\Application\Module\Mapper;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Topic\Service\TopicContentResolver;
use App\Models\LMS\Stage;
use App\Models\LMS\Topic;

final readonly class ModuleMapper
{
    public function __construct(
        private TopicContentResolver $topicResolver,
    ) {
    }

    public function fromModel(Stage $stage, array $lessons, array $quizzes): ModuleDto
    {
        $validTopics = $stage->topics->filter(function (Topic $topic) use ($lessons, $quizzes) {
            $hasLesson = isset($lessons[$topic->id]);
            $hasQuiz = isset($quizzes[$topic->id]);

            return $hasLesson || $hasQuiz;
        });

        return new ModuleDto(
            id: $stage->id,
            title: $stage->name,
            topics: $validTopics
                ->map(fn(Topic $topic) => $this->topicResolver->resolveContent(
                    topic: $topic,
                    lessonsLookUp: $lessons,
                    quizzesLookUp: $quizzes)
                )->toArray()
        );
    }
}
