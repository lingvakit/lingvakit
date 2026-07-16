<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Request\Quiz;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use Symfony\Component\Uid\Uuid;

class QuizCreateRequestDto
{
    public function __construct(
        public int $moduleId,
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $imageMediaId = null,
        public ?int $audioMediaId = null,
        public ?int $videoMediaId = null,
        public int $timeLimit,
        public int $passingScore,
        public QuizStatusEnum $status,
        public ?int $orderIndex = null,
        public ?array $passedTopics = null,
    ) {}

    public function convertToArray(): array
    {
        return [
            'uuid' => $this->uuid->toRfc4122(),
            'title' => $this->title,
            'description' => $this->description ?? null,
            'imageId' => $this->imageMediaId,
            'videoId' => $this->videoMediaId,
            'audioId' => $this->audioMediaId,
            'timeLimit' => $this->timeLimit,
            'passingScore' => $this->passingScore,
            'status' => $this->status,
        ];
    }
}
