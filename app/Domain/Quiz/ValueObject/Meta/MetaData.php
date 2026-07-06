<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\Meta;

use App\Domain\Quiz\Enum\QuestionFontSizeEnum;
use App\Domain\Quiz\ValueObject\MetaValueObject;

readonly class MetaData implements MetaValueObject
{
    public function  __construct(
        private QuestionFontSizeEnum $fontSize,
    ) {}

    public function toArray(): array
    {
        return [
            'fontSize' => $this->fontSize
        ];
    }
}
