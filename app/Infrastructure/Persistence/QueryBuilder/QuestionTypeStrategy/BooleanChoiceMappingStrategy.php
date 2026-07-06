<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\BooleanChoiceAnswer;

class BooleanChoiceMappingStrategy extends AbstractQuestionMapping
{
    public function supports(string $legacyType): bool
    {
        $legacyTypeEnum = LegacyQuestionTypeEnum::tryFrom($legacyType);
        if ($legacyTypeEnum === null) {
            return false;
        }

        return $legacyTypeEnum === LegacyQuestionTypeEnum::LogicChoice;
    }

    protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids
    ): AnswerValueObject
    {
        $correctAnswer = false;
        $optionAnswerMap = [
            'true' => true,
            'false' => false,
        ];

        foreach ($currentOptions as $option) {
            if ($option->is_correct) {
                $correctAnswer = $optionAnswerMap[$option->value] ?? false;
            }
        }

        return new BooleanChoiceAnswer($correctAnswer);
    }
}
