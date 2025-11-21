<?php

declare(strict_types=1);

namespace App\Application\Quiz\Dto;

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
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? "",
            timeLimit: isset($data['timeLimit']) ? (int)$data['timeLimit'] : null,
            passingScore: isset($data['passingScore']) ? (int)$data['passingScore'] : null,
            description: $data['description'] ?? null,
            imageId: $data['imageId'] ?? null,
            videoId: $data['videoId'] ?? null,
            audioId: $data['audioId'] ?? null,
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
}
