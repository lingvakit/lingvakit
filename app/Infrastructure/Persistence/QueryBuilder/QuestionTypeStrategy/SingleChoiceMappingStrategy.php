<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\SingleChoiceAnswer;

class SingleChoiceMappingStrategy extends AbstractQuestionMapping
{
    public function supports(string $legacyType): bool
    {
        if (!LegacyQuestionTypeEnum::tryFrom($legacyType)) {
            return false;
        }

        return in_array(
            needle: LegacyQuestionTypeEnum::from($legacyType),
            haystack: [
                LegacyQuestionTypeEnum::SingleChoice,
                LegacyQuestionTypeEnum::MultipleChoice,
            ],
            strict: true
        );
    }

    protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids
    ): AnswerValueObject
    {
        $correctOptionUuids = [];

        foreach ($currentOptions as $option) {
            if ($option->is_correct) {
                $correctOptionUuids[] = $optionUuids[$option->id];
            }
        }

        return new SingleChoiceAnswer($correctOptionUuids);
    }
}
