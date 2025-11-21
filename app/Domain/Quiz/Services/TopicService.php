<?php

declare(strict_types=1);

namespace App\Domain\Quiz\Services;

use App\Models\LMS\Stage;
use App\Models\LMS\Topic;

class TopicService
{
    public function createTopic(Stage $stage, string $type = 'quiz', string $requiredTopics = null): Topic
    {
        return Topic::create([
            'name' => $type,
            'stage_id' => $stage->id,
            'passed_topics' => $requiredTopics,
        ]);
    }

    public function updateRequiredTopics(Topic $topic, string $requiredTopics = null): void
    {
        $topic->passed_topics = $requiredTopics;
        $topic->save();
    }
}
