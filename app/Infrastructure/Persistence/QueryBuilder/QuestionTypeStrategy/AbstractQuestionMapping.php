<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Entity\QuestionEntity;
use App\Domain\Quiz\Entity\QuestionGroupEntity;
use App\Domain\Quiz\Entity\QuestionOptionEntity;
use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\Enum\QuestionFontSizeEnum;
use App\Domain\Quiz\Enum\QuestionTypeEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\MediaFile\AudioFileVO;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\Meta\MetaData;
use App\Models\LMS\ConformityOption;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

abstract class AbstractQuestionMapping implements QuestionMappingStrategyInterface
{
    /**
     * @throws \DateMalformedStringException
     */
    public function map(
        object $legacyQuestion,
        array $conformities,
        array $options
    ): QuestionGroupEntity {
        $questionType = LegacyQuestionTypeEnum::from($legacyQuestion->type);
        $isRequiredOptions = $questionType !== LegacyQuestionTypeEnum::LogicChoice;

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
                $legacyQuestion,
                $conformity,
                $questionType,
                $options,
                $isRequiredOptions
            );

            $questionsGroup->addQuestion($question);
        }

        return $questionsGroup;
    }

    /**
     * @throws \DateMalformedStringException
     */
    protected function prepareQuestionGroupEntity(
        object $legacyQuestion,
        QuestionTypeEnum $questionType
    ): QuestionGroupEntity {
        $group = new QuestionGroupEntity(
            uuid: Uuid::v4(),
            title: $legacyQuestion->title,
            description: null,
            orderIndex: null,
            questionType: $questionType,
            questions: [],
            media: [],
            meta: $legacyQuestion->font_size
                ? new MetaData(QuestionFontSizeEnum::from($legacyQuestion->font_size))
                : null,
            createdAt: $legacyQuestion->created_at
                ? new DateTimeImmutable($legacyQuestion->created_at)
                : new DateTimeImmutable(),
            updatedAt: $legacyQuestion->updated_at
                ? new DateTimeImmutable($legacyQuestion->created_at)
                : null,
        );

        if (ctype_digit((string)$legacyQuestion->image)) {
            $group->addMedia(new ImageFileVO((int)$legacyQuestion->image));
        }

        if (ctype_digit((string)$legacyQuestion->audio)) {
            $group->addMedia(new AudioFileVO((int)$legacyQuestion->audio));
        }

        return $group;
    }

    /**
     * @param ConformityOption[] $options
     * @throws \DateMalformedStringException
     */
    protected function prepareQuestionEntity(
        object $legacyQuestion,
        object $conformity,
        LegacyQuestionTypeEnum $questionType,
        array $options,
        ?bool $isRequiredOptions = true,
        ?string $customQuestionText = null,
    ): QuestionEntity {
        $questionOptions = [];
        $optionUuids = [];

        $currentOptions = array_filter(
            $options,
            fn($option) => $option->conformity_id == $conformity->id
        );

        foreach ($currentOptions as $option) {
            $optionUuid = Uuid::v4();
            $questionOptions[] = $this->prepareQuestionOptionEntity($option, $optionUuid);
            $optionUuids[$option->id] = $optionUuid;
        }

        $answerVO = $this->buildAnswer($conformity, $currentOptions, $optionUuids, $questionType);
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
            createdAt: $conformity->created_at
                ? new DateTimeImmutable($conformity->created_at)
                : new DateTimeImmutable(),
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

        if ($isRequiredOptions) {
            foreach ($questionOptions as $questionOption) {
                $question->addOption($questionOption);
            }
        }

        return $question;
    }

    /**
     * @throws \DateMalformedStringException
     */
    protected function prepareQuestionOptionEntity(
        object $option,
        Uuid $optionUuid
    ): QuestionOptionEntity {
        return new QuestionOptionEntity(
            id: $option->id,
            uuid: $optionUuid,
            text: $option->value,
            matchKey: null,
            orderIndex: null,
            media: null,
            settings: null,
            createdAt: $option->created_at
                ? new DateTimeImmutable($option->created_at)
                : new DateTimeImmutable(),
            updatedAt: $option->updated_at
                ? new DateTimeImmutable($option->updated_at)
                : null,
        );
    }

    protected function resolveQuestionText(object $conformity): string
    {
        return $conformity->title;
    }

    /**
     * @param object $conformity
     * @param object[] $currentOptions
     * @param array<int, Uuid> $optionUuids
     * @param LegacyQuestionTypeEnum $questionType
     */
    abstract protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids,
        LegacyQuestionTypeEnum $questionType
    ): AnswerValueObject;
}
