<?php
declare(strict_types=1);

namespace App\Application\Quiz\Dto\QuestionsGroup\Request\Question;

use App\Domain\Quiz\ValueObject\MediaValueObject;
use Symfony\Component\Uid\Uuid;

class QuestionOptionCreateDto
{
    public function __construct(
        public ?Uuid $questionUuid = null,
        public Uuid $uuid,
        public ?string $text = null,
        public ?Uuid $matchKey = null,
        public ?int $orderIndex = null,

        /** @var MediaValueObject[] */
        public ?array $media = null,
        public ?array $settings = null,
    ) {}
}
