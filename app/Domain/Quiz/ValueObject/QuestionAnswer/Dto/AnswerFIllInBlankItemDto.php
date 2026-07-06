<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\QuestionAnswer\Dto;

use Symfony\Component\Uid\Uuid;

class AnswerFIllInBlankItemDto
{
    public function __construct(
        public int $index,
        public Uuid $optionUuid,
    ) {
    }
}
