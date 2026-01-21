<?php

declare(strict_types=1);

namespace App\Application\Quiz\Services;

use App\Application\Quiz\Dto\Question\AnswerDto;
use App\Application\Quiz\Dto\QuestionDto;
use App\Application\Quiz\Dto\QuestionGroup\MediaDto;
use App\Application\Quiz\Dto\QuestionGroup\MetaDto;
use App\Application\Quiz\Dto\QuestionGroupDto;
use App\Application\Quiz\Dto\QuestionOptionDto;
use App\Application\Quiz\Enum\MediaType;
use App\Application\Quiz\Enum\QuestionType;
use App\Domain\Media\Repositories\MediaRepository;
use App\Infrastructure\MS\Quiz\QuestionGroupGateway;
use App\Models\LMS\Course;
use App\Models\LMS\Quiz;
use App\Models\LMS\Stage;
use Symfony\Component\Uid\Uuid;

readonly class QuestionGroupViewService
{
    public function __construct(
        private QuestionGroupGateway $gateway,
        private MediaRepository $mediaRepository,
    ) {
    }

    public function prepareDataForShowView(
        Course $course,
        Stage $stage,
        Quiz $quiz,
        string $uuid
    ): array {
        $questionGroupData = $this->gateway->getDataFromMs(
            Uuid::fromString($uuid)
        );

        return [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'questionGroupDto' => new QuestionGroupDto(
                uuid: $questionGroupData['uuid'],
                title: $questionGroupData['title'],
                questionType: $questionGroupData['questionType'],
                description: $questionGroupData['description'],
                media: array_map(
                    fn($m) => new MediaDto(
                        type: MediaType::from($m['type']),
                        mediaId: $m['mediaId'],
                        alt: $m['alt'] ?? null,
                    ),
                    $questionGroupData['media'] ?? []
                ),
                meta: new MetaDto(
                    style: $questionGroupData['meta']['style'] ?? null
                ),
                questions: array_map(
                    fn($q) => new QuestionDto(
                        text: $q['text'],
                        type: $q['type'],
                        points: $q['points'],
                        explanation: $q['explanation'],
                        orderIndex: $q['orderIndex'],
                        settings: $q['settings'],
                        answer: $q['answer']
                            ? new AnswerDto(
                                questionType: QuestionType::from($q['answer']['type']),
                                value: $q['answer']['value']
                            )
                            : null,
                        options: array_map(
                            fn($o) => new QuestionOptionDto(
                                uuid: Uuid::fromString($o['uuid']),
                                text: $o['text'],
                                matchKey: $o['matchKey'],
                                orderIndex: $o['orderIndex'],
                                settings: $o['settings'],
                            ),
                            $q['options'] ?? [],
                        ),
                    ),
                    $questionGroupData['questions'] ?? [],
                )
            ),
        ];
    }

    public function prepareDataForCreateView(
        Course $course,
        Stage $stage,
        Quiz $quiz,
        QuestionType $questionType
    ): array {
        return [
            'course' => $course,
            'stage' => $stage,
            'quiz' => $quiz,
            'questionType' => $questionType->value,
            'audioFiles' => $this->mediaRepository->getAllByType('audio'),
            'images' => $this->mediaRepository->getAllByType('image'),
        ];
    }
}
