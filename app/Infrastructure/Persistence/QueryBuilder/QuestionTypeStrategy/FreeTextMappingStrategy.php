<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Entity\QuestionEntity;
use App\Domain\Quiz\Entity\QuestionGroupEntity;
use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\QuestionAnswer\FreeTextAnswer;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class FreeTextMappingStrategy extends AbstractQuestionMapping
{
    public function supports(string $legacyType): bool
    {
        return in_array(
            needle: LegacyQuestionTypeEnum::from($legacyType),
            haystack: [
                LegacyQuestionTypeEnum::ShortAnswer,
                LegacyQuestionTypeEnum::ListenWrite,
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
            $question = $this->buildFreeTextQuestion(
                legacyQuestion: $legacyQuestion,
                conformity: $conformity,
                questionType: $questionType,
                options: $options,
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
        $text = null;

        foreach ($currentOptions as $option) {
            if ($option->is_correct) {
                $text = $option->value;
                break;
            }
        }

        return new FreeTextAnswer($text);
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function buildFreeTextQuestion(
        object $legacyQuestion,
        object $conformity,
        LegacyQuestionTypeEnum $questionType,
        array $options,
    ): QuestionEntity {
        $optionUuids = [];

        $currentOptions = array_filter(
            $options,
            fn($option) => $option->conformity_id == $conformity->id
        );

        foreach ($currentOptions as $option) {
            $optionUuid = Uuid::v4();
            $optionUuids[$option->id] = $optionUuid;
        }

        $answerVO = $this->buildAnswer($conformity, $currentOptions, $optionUuids);
        $questionText = $customQuestionText ?? $this->resolveQuestionText($conformity);

        $question = new QuestionEntity(
            id: $legacyQuestion->id,
            uuid: Uuid::v4(),
            text: $questionText,
            explanation: $legacyQuestion->explanation,
            points: (int)$conformity->points,
            orderIndex: null,
            type: $questionType->convertForMsQuiz(),
            media: [],
            settings: null,
            answer: $answerVO,
            options: [],
            createdAt: !$conformity->created_at
                ? new DateTimeImmutable()
                : new DateTimeImmutable($conformity->created_at),
            updatedAt: $conformity->updated_at
                ? new DateTimeImmutable($conformity->updated_at)
                : null,
        );

        if (ctype_digit((string)$conformity->image)) {
            $question->addMedia(new ImageFileVO((int)$conformity->image));
        }

        if (ctype_digit((string)$conformity->audio)) {
            $question->addMedia(new AudioFileVO((int)$conformity->audio));
        }

        return $question;
    }
}
