<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Entity\QuestionGroupEntity;
use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\SentenceBuildAnswer;

class SentenceBuildMappingStrategy extends AbstractQuestionMapping
{
    private const string QUESTION_TEXT = "Составьте текст из слов или фраз";

    public function supports(string $legacyType): bool
    {
        return in_array(
            needle: LegacyQuestionTypeEnum::from($legacyType),
            haystack: [
                LegacyQuestionTypeEnum::MakeSentence,
                LegacyQuestionTypeEnum::MakeText,
            ],
            strict: true
        );
    }

    public function map(
        object $legacyQuestion,
        array $conformities,
        array $options
    ): QuestionGroupEntity {
        $questionType = LegacyQuestionTypeEnum::from($legacyQuestion->type);
        $questionsGroup = $this->prepareQuestionGroupEntity(
            legacyQuestion: $legacyQuestion,
            questionType: $questionType->convertForMsQuiz()
        );

        $groupConformities = array_filter(
            $conformities,
            fn($conformity) => $conformity->question_id == $legacyQuestion->id
        );

        foreach ($groupConformities as $conformity) {
            $question = $this->prepareQuestionEntity(
                legacyQuestion: $legacyQuestion,
                conformity: $conformity,
                questionType: $questionType,
                options: $options,
                customQuestionText: self::QUESTION_TEXT
            );

            $question->setExplanation($conformity->title);

            $questionsGroup->addQuestion($question);
        }

        return $questionsGroup;
    }

    protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids
    ): AnswerValueObject
    {
        $sequenceUuids = [];

        foreach ($currentOptions as $option) {
            if ($option->is_correct) {
                $sequenceUuids[] = $optionUuids[$option->id];
            }
        }

        return new SentenceBuildAnswer($sequenceUuids);
    }
}
