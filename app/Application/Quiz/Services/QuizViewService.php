<?php

declare(strict_types=1);

namespace App\Application\Quiz\Services;

use App\Application\Quiz\Actions\GetAction;
use App\Domain\Category\Repositories\CategoryRepository;
use App\Domain\Media\Repositories\MediaRepository;
use App\Infrastructure\MS\Media\MediaGateway;
use App\Models\LMS\Course;
use App\Models\LMS\QuestionType;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;

readonly class QuizViewService
{
    public function __construct(
        private GetAction $getQuizAction,
        private MediaGateway $mediaService,
        private CategoryRepository $categoryRepository,
        private MediaRepository $mediaRepository,
    ) {
    }

    public function prepareDataForShowView(Course $course, Stage $stage, Quiz $quiz): array
    {
        $quizDto = $this->getQuizAction->execute($quiz->uuid);

        $imageUrl = $this->mediaService->getMediaUrl($quizDto->getImageId());
        $videoUrl = $this->mediaService->getMediaUrl($quizDto->getVideoId());
        $audioUrl = $this->mediaService->getMediaUrl($quizDto->getAudioId());
        $quizTimeLimit = $this->mediaService->getDurationText($quizDto->getTimeLimit());

        return [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'quizDto' => $quizDto,
            'quizImageUrl' => $imageUrl,
            'quizVideoUrl' => $videoUrl,
            'quizAudioUrl' => $audioUrl,
            'quizTimeLimit' => $quizTimeLimit,
            'questionTypes' => QuestionType::all(),
        ];
    }

    public function prepareDataForCreateView(Course $course, Stage $stage): array
    {
        return array_merge(
            [
                'course' => $course,
                'stage' => $stage,
            ],
            $this->prepareDefaultData()
        );
    }

    public function prepareDataForEditView(Course $course, Stage $stage, Quiz $quiz): array
    {
        $quizDto = $this->getQuizAction->execute($quiz->uuid);
        $imageUrl = $this->mediaService->getMediaUrl($quizDto->getImageId());
        $videoUrl = $this->mediaService->getMediaUrl($quizDto->getVideoId());
        $audioUrl = $this->mediaService->getMediaUrl($quizDto->getAudioId());

        return array_merge(
            [
                'course' => $course,
                'stage' => $stage,
                'quiz' => $quiz,
                'quizDto' => $quizDto,
                'quizImageUrl' => $imageUrl,
                'quizVideoUrl' => $videoUrl,
                'quizAudioUrl' => $audioUrl,
            ],
            $this->prepareDefaultData()
        );
    }

    private function prepareDefaultData(): array
    {
        return [
            'categories' => $this->categoryRepository->allExceptUncategorized(),
            'audioFiles' => $this->mediaRepository->getAllByType('audio'),
            'images' => $this->mediaRepository->getAllByType('image'),
        ];
    }
}
