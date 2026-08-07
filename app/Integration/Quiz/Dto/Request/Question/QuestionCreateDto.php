<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\Request\Question;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto as AppQuestionCreateDto;

class QuestionCreateDto extends AppQuestionCreateDto
{
    public function convertToArray(): array
    {
        return [
            'groupUuid' => $this->groupUuid->toRfc4122(),
            'uuid' => $this->uuid->toRfc4122(),
            'text' => $this->text,
            'explanation' => $this->explanation ?? null,
            'points' => $this->points ?? null,
            'type' => $this->type->value,
            'orderIndex' => $this->orderIndex ?? null,
            'settings' => $this->settings ?? null,
            'options' => $this->options ?? [],
            'answer' => $this->answer ? [
                'questionType' => $this->answer->questionType->value,
                'value' => array_map(
                    fn($uuid) => (string) $uuid,
                    $this->answer->value
                ),
            ] : null,
        ];
    }
}
