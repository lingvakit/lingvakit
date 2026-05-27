<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\Response;

use App\Application\Media\Dto\MediaFileDto;
use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto;
use Symfony\Component\Uid\Uuid;

final readonly class QuizDto
{
    public function __construct(
        public Uuid $uuid,
        public string $title,
        public ?string $description = null,
        public ?MediaFileDto $imageFile = null,
        public ?MediaFileDto $audioFile = null,
        public ?MediaFileDto $videoFile = null,
        public int $timeLimit,
        public int $passingScore,
        public QuizStatusEnum $status,
        public ?int $orderIndex = null,

        /** @var QuestionsGroupDto[] */
        public array $questionGroups = [],
    ) {
    }
}
