<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer\Dto;

use Symfony\Component\Uid\Uuid;

class AnswerMatchItemDto
{
    public function __construct(
        public Uuid $leftUuid,
        public Uuid $rightUuid,
    ) {}
}
