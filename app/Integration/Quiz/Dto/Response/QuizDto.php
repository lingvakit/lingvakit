<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Response;

use App\Domain\Quiz\Enum\QuizStatusEnum;

class QuizDto
{
    public function __construct(
        public string $uuid,
        public string $title,
        public ?string $description = null,
        public ?int $imageId = null,
        public ?int $audioId = null,
        public ?int $videoId = null,
        public int $timeLimit,
        public int $passingScore,
        public QuizStatusEnum $status,

        /** @var QuestionsGroupDto[] */
        public array $questionGroups = [],
    ) {
    }
}
