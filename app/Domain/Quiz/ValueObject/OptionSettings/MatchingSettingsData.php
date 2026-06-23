<?php
declare(strict_types=1);

namespace App\Domain\Quiz\ValueObject\OptionSettings;

use App\Domain\Quiz\Enum\QuestionOptionMatchSideEnum;
use App\Domain\Quiz\ValueObject\SettingsValueObject;

readonly class MatchingSettingsData implements SettingsValueObject
{
    public function __construct(
        private ?QuestionOptionMatchSideEnum $matchSide = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        if ($this->matchSide) {
            $data['matchSide'] = $this->matchSide->value;
        }

        return $data;
    }
}
