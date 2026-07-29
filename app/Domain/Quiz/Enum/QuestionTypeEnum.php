<?php
declare(strict_types = 1);

namespace App\Domain\Quiz\Enum;

use App\Integration\Quiz\Dto\Response\QuestionAnswerDto;

enum QuestionTypeEnum: string
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case Boolean = 'boolean';
    case FillInBlank = 'fill_in_blank';
    case Match = 'match';
    case SentenceBuild = 'sentence_build';
    case FreeText = 'free_text';

    /**
     * @param array{
     *     questionType: string,
     *     value: mixed
     * } $answer
     * @return QuestionAnswerDto
     */
    public static function getAnswerDto(array $answer): QuestionAnswerDto
    {
        $questionType = self::from($answer['questionType']);

        return match ($answer['questionType']) {
            self::SingleChoice->value,
            self::MultipleChoice->value => new QuestionAnswerDto(
                questionType: $questionType,
                value: $answer['value'],
            ),
            self::Boolean->value=> new QuestionAnswerDto(
                questionType: $questionType,
                boolean: $answer['value'],
            ),
            self::FillInBlank->value=> new QuestionAnswerDto(
                questionType: $questionType,
                blanks: $answer['value'],
            ),
            self::Match->value=> new QuestionAnswerDto(
                questionType: $questionType,
                pairs: $answer['value'],
            ),
            self::SentenceBuild->value=> new QuestionAnswerDto(
                questionType: $questionType,
                sequence: $answer['value'],
            ),
            self::FreeText->value=> new QuestionAnswerDto(
                questionType: $questionType,
                text: $answer['value'],
            ),
        };
    }
}
