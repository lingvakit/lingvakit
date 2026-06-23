<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Enum;

enum LegacyQuestionTypeEnum: string
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case LogicChoice = 'logic_choice';
    case FillTheGaps = 'fill_the_gaps';
    case Matching = 'matching';
    case MakeSentence = 'make_sentence';
    case MakeText = 'make_text';
    case ShortAnswer = 'short_answer';
    case ListenWrite = 'listen_write';

    public function convertForMsQuiz(): QuestionTypeEnum
    {
        return match ($this) {
            self::SingleChoice => QuestionTypeEnum::SingleChoice,
            self::MultipleChoice => QuestionTypeEnum::MultipleChoice,
            self::LogicChoice => QuestionTypeEnum::Boolean,
            self::FillTheGaps => QuestionTypeEnum::FillInBlank,
            self::Matching => QuestionTypeEnum::Match,
            self::MakeSentence,
            self::MakeText => QuestionTypeEnum::SentenceBuild,
            self::ShortAnswer,
            self::ListenWrite => QuestionTypeEnum::FreeText,
        };
    }
}
