<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto;

use App\Application\Quiz\Dto\Question\AnswerDto;
use App\Application\Quiz\Dto\QuestionGroup\MediaDto;
use App\Application\Quiz\Dto\QuestionGroup\MetaDto;
use App\Application\Quiz\Enum\MediaType;
use App\Application\Quiz\Enum\QuestionType;

readonly class QuizDto
{
    public function __construct(
        private string $title,
        private int $timeLimit,
        private int $passingScore,
        private ?string $description = null,
        private ?int $imageId = null,
        private ?int $videoId = null,
        private ?int $audioId = null,

        /** @var array<QuestionGroupDto> */
        private ?array $questionGroups = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? "",
            timeLimit: (int) ($data['timeLimit'] ?? 0),
            passingScore: (int) ($data['passingScore'] ?? 0),
            description: $data['description'] ?? null,
            imageId: $data['imageId'] ?? null,
            videoId: $data['videoId'] ?? null,
            audioId: $data['audioId'] ?? null,

            /** @var QuestionGroupDto[] */
            questionGroups: array_map(
                fn(array $g) => new QuestionGroupDto(
                    uuid: $g['uuid'],
                    title: $g['title'],
                    questionType: $g['questionType'],
                    description: $g['description'],
                    media: new MediaDto(
                        MediaType::Image,
                        2,
                        ''
                    ),
                    meta: new MetaDto(
                        style:  $g['meta'] ?? null
                    ),
                    questions: array_map(
                        fn(array $q) => new QuestionDto(
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
                            options: $q['options'],
                        ),
                        $g['questions'] ?? []
                    ),
                ),
                $data['currentVersion']['questionGroups'] ?? []
            ),
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTimeLimit(): int
    {
        return $this->timeLimit;
    }

    public function getPassingScore(): int
    {
        return $this->passingScore;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImageId(): ?int
    {
        return $this->imageId;
    }

    public function getVideoId(): ?int
    {
        return $this->videoId;
    }

    public function getAudioId(): ?int
    {
        return $this->audioId;
    }

    public function getQuestionGroups(): ?array
    {
        return $this->questionGroups;
    }
}
