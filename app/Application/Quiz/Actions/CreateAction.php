<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions;

use App\Domain\Quiz\Repositories\QuizRepository;
use App\Domain\Quiz\Services\CategoryService;
use App\Domain\Quiz\Services\TopicService;
use App\Infrastructure\MS\Quiz\QuizGateway;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;

readonly class CreateAction
{
    public function __construct(
        private CategoryService $categoryService,
        private TopicService $topicService,
        private QuizGateway $quizGateway,
        private QuizRepository $quizRepository,
    ) {
    }

    public function execute(array $data, Course $course, Stage $stage): Quiz
    {
        // Find or create category
        $category = $this->categoryService->resolve($data);

        // Create topic
        $topic = $this->topicService->createTopic(
            stage: $stage,
            requiredTopics: isset($data['passed_topics']) ? implode(',', $data['passed_topics']) : null
        );
        $topic->update(['index_number' => $topic->id]);

        // Create quiz in microservice
        $uuid = $this->quizGateway->createQuizInMs($data);

        // Create quiz in database
        $quiz = $this->quizRepository->store([
            'uuid' => $uuid,
            'title' => $data['title'], /** @deprecated: will be removed */
            'topic_id' => $topic->id,
            'category_id' => $category->id,
        ]);

        // Update course
        $course->updateDuration();

        return $quiz;
    }
}