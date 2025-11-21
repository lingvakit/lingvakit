<?php

declare(strict_types=1);

namespace App\Application\Quiz\Actions;

use App\Domain\Quiz\Repositories\QuizRepository;
use App\Domain\Topic\Repositories\TopicRepository;
use App\Infrastructure\MS\Quiz\QuizGateway;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;

readonly class DeleteAction
{
    public function __construct(
        private QuizGateway $quizGateway,
        private TopicRepository $topicRepository,
        private QuizRepository $quizRepository,
    ) {
    }

    public function execute(Course $course, Quiz $quiz): void
    {
        $topicId = $quiz->topic_id;

        // Delete quiz from microservice
        $this->quizGateway->deleteQuizFromMs($quiz);

        // Delete quiz from database
        $this->quizRepository->delete($quiz);

        // Delete topic from database
        $this->topicRepository->delete($topicId);

        // Update course
        $course->updateDuration();
    }
}
