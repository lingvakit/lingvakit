<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Entity\QuestionEntity;
use App\Domain\Quiz\Entity\QuestionGroupEntity;
use App\Domain\Quiz\Entity\QuestionOptionEntity;
use App\Domain\Quiz\Enum\LegacyQuestionTypeEnum;
use App\Domain\Quiz\Enum\QuestionFontSizeEnum;
use App\Domain\Quiz\Enum\QuestionOptionMatchSideEnum;
use App\Domain\Quiz\ValueObject\AnswerValueObject;
use App\Domain\Quiz\ValueObject\MediaFile\ImageFileVO;
use App\Domain\Quiz\ValueObject\Meta\MetaData;
use App\Domain\Quiz\ValueObject\OptionSettings\MatchingSettingsData;
use App\Domain\Quiz\ValueObject\SettingsValueObject;
use App\Domain\Quiz\ValueObject\QuestionAnswer\Dto\AnswerMatchItemDto;
use App\Domain\Quiz\ValueObject\QuestionAnswer\MatchAnswer;
use DateTimeImmutable;
use LogicException;
use Symfony\Component\Uid\Uuid;

class MatchMappingStrategy extends AbstractQuestionMapping
{
    public function supports(string $legacyType): bool
    {
        $legacyTypeEnum = LegacyQuestionTypeEnum::tryFrom($legacyType);
        if ($legacyTypeEnum === null) {
            return false;
        }

        return $legacyTypeEnum === LegacyQuestionTypeEnum::Matching;
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function map(
        object $legacyQuestion,
        array $conformities,
        array $options
    ): QuestionGroupEntity {
        $questionType = LegacyQuestionTypeEnum::from($legacyQuestion->type);
        $questionsGroup = $this->prepareCustomGroupEntity($legacyQuestion, $questionType);

        $question = $this->buildMatchingQuestion(
            $legacyQuestion,
            $conformities,
            $options,
            $questionType
        );

        $questionsGroup->addQuestion($question);

        return $questionsGroup;
    }

    private function prepareCustomGroupEntity(
        object $legacyQuestion,
        LegacyQuestionTypeEnum $questionType
    ): QuestionGroupEntity {
        return new QuestionGroupEntity(
            uuid: Uuid::v4(),
            title: "Вопросы на соответствие",
            description: null,
            orderIndex: null,
            questionType: $questionType->convertForMsQuiz(),
            questions: [],
            media: null,
            meta: $legacyQuestion->font_size
                ? new MetaData(
                    QuestionFontSizeEnum::from($legacyQuestion->font_size)
                ) : null,
            createdAt: $this->parseDate($legacyQuestion->created_at),
            updatedAt: $this->parseDate($legacyQuestion->updated_at, true),
        );
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function buildMatchingQuestion(
        object $legacyQuestion,
        array $conformities,
        array $options,
        LegacyQuestionTypeEnum $questionType
    ): QuestionEntity {
        $questionOptions = [];
        $answerPairs = [];
        $totalPoints = 0;

        $questionConformities = array_filter(
            $conformities,
            fn($c) => $c->question_id == $legacyQuestion->id
        );

        foreach ($questionConformities as $conformity) {
            $leftUuid = Uuid::v4();
            $totalPoints += (int)$conformity->points;

            $leftOption = $this->createOptionEntity(
                id: $conformity->id,
                uuid: $leftUuid,
                text: $conformity->title,
                createdAt: $conformity->created_at,
                updatedAt: $conformity->updated_at,
                settings: new MatchingSettingsData(
                    matchSide: QuestionOptionMatchSideEnum::Left
                )
            );

            $currentOptions = array_filter(
                $options,
                fn($option) => $option->conformity_id == $conformity->id
            );

            foreach ($currentOptions as $currentOption) {
                $rightUuid = Uuid::v4();
                $rightOption = $this->createOptionEntity(
                    id: $currentOption->id,
                    uuid: $rightUuid,
                    text: $currentOption->value,
                    createdAt: $conformity->created_at,
                    updatedAt: $conformity->updated_at,
                    settings: new MatchingSettingsData(
                        matchSide: QuestionOptionMatchSideEnum::Right
                    )
                );

                if ($currentOption->is_correct) {
                    $leftOption->setMatchKey($rightUuid);
                    $rightOption->setMatchKey($leftUuid);

                    $answerPairs[] = new AnswerMatchItemDto($leftUuid, $rightUuid);
                }

                $questionOptions[] = $rightOption;
            }

            $questionOptions[] = $leftOption;
        }

        $question = new QuestionEntity(
            id: $legacyQuestion->id,
            uuid: Uuid::v4(),
            text: $legacyQuestion->title,
            explanation: $legacyQuestion->explanation,
            points: $totalPoints > 0 ? $totalPoints : 10,
            orderIndex: null,
            type: $questionType->convertForMsQuiz(),
            media: [],
            settings: null,
            answer: new MatchAnswer($answerPairs),
            options: $questionOptions,
            createdAt: $this->parseDate($legacyQuestion->created_at),
            updatedAt: $this->parseDate($legacyQuestion->updated_at, true),
        );

        if (
            !empty($legacyQuestion->image)
            && ctype_digit((string)$legacyQuestion->image)
        ) {
            $question->addMedia(new ImageFileVO((int)$legacyQuestion->image));
        }

        return $question;
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function createOptionEntity(
        int $id,
        Uuid $uuid,
        string $text,
        ?string $createdAt,
        ?string $updatedAt,
        ?SettingsValueObject $settings = null,
    ): QuestionOptionEntity {
        return new QuestionOptionEntity(
            id: $id,
            uuid: $uuid,
            text: $text,
            matchKey: null,
            orderIndex: null,
            media: null,
            settings: $settings,
            createdAt: $this->parseDate($createdAt),
            updatedAt: $this->parseDate($updatedAt, true),
        );
    }

    /**
     * @throws \DateMalformedStringException
     */
    private function parseDate(?string $date, bool $nullable = false): ?DateTimeImmutable
    {
        if (!$date) {
            return $nullable ? null : new DateTimeImmutable();
        }

        return new DateTimeImmutable($date);
    }

    protected function buildAnswer(
        object $conformity,
        array $currentOptions,
        array $optionUuids
    ): AnswerValueObject  {
        throw new LogicException('Method buildAnswer is not used in MatchMappingStrategy');
    }
}
