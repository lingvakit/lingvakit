<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions;

use App\Domain\Quiz\Repositories\QuizRepository;
use App\Domain\Quiz\Services\CategoryService;
use App\Domain\Quiz\Services\TopicService;
use App\Infrastructure\MS\Quiz\QuizGateway;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;

readonly class UpdateAction
{
    public function __construct(
        private CategoryService $categoryService,
        private TopicService $topicService,
        private QuizGateway $quizGateway,
        private QuizRepository $quizRepository,
    ) {
    }

    public function execute(array $data, Quiz $quiz, Course $course): Quiz
    {
        // Find or create category
        $category = $this->categoryService->resolve($data);

        // Update quiz in microservice
        $this->quizGateway->updateQuizInMs($data, $quiz);

        // Update quiz in database
        $this->quizRepository->update($quiz, [
            'title' => $data['title'], /** @deprecated: will be removed */
            'category_id' => $category->id,
        ]);

        // Update required topics
        $this->topicService->updateRequiredTopics(
            topic: $quiz->topic,
            requiredTopics: isset($data['passed_topics']) ? implode(',', $data['passed_topics']) : null
        );

        // Update course
        $course->updateDuration();

        return $quiz;
    }
}