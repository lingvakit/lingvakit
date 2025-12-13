<?php

declare (strict_types=1);

namespace App\Application\Quiz\Services;

use App\Domain\Media\Repositories\MediaRepository;
use App\Infrastructure\MS\Quiz\QuestionGateway;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;

readonly class QuestionViewService
{
    public function __construct(
        private MediaRepository $mediaRepository,
        private QuestionGateway $questionGateway,
    ) {
    }

    public function prepareDataForCreateView(Course $course, Stage $stage, Quiz $quiz, $questionType): array
    {
        return [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'questionType' => $questionType,
            'audioFiles' => $this->mediaRepository->getAllByType('audio'),
            'images' => $this->mediaRepository->getAllByType('image'),
        ];
    }

    public function prepareDataForShowView(Course $course, Stage $stage, Quiz $quiz, string $questionUuid): array
    {
        $questionData = $this->questionGateway->getQuestionDataFromMs($questionUuid);

        $ff = 0;

        return [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'questionData' => $questionData,
        ];
    }
}