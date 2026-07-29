<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\Dto\AnswerFIllInBlankItemDto;
use App\Domain\Quiz\ValueObject\QuestionAnswer\FillInGapAnswer;

class FillInBlankMappingStrategy extends AbstractQuestionMapping
{
    public function supports(string $legacyType): bool
    {
        $legacyTypeEnum = LegacyQuestionTypeEnum::tryFrom($legacyType);
        if ($legacyTypeEnum === null) {
            return false;
        }

        return $legacyTypeEnum === LegacyQuestionTypeEnum::FillTheGaps;
    }

    protected function resolveQuestionText(object $conformity): string
    {
        $sourceText = $conformity->title;

        if ($conformity->word_number === null || $conformity->word_number <= 0) {
            return $sourceText;
        }

        $textWords = explode(' ', $sourceText);

        array_splice(
            array: $textWords,
            offset: (int)$conformity->word_number - 1,
            length: 0,
            replacement: "___"
        );

        return implode(' ', $textWords);
    }

    protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids,
        LegacyQuestionTypeEnum $questionType
    ): AnswerValueObject
    {
        $answerBlanks = [];

        foreach ($currentOptions as $option) {
            if ($option->is_correct
                && $conformity->word_number !== null
                && $conformity->word_number > 0
            ) {
                $answerBlanks[] = new AnswerFIllInBlankItemDto(
                    index: (int)$conformity->word_number - 1,
                    optionUuid: $optionUuids[$option->id],
                );
            }
        }

        return new FillInGapAnswer($answerBlanks);
    }
}
