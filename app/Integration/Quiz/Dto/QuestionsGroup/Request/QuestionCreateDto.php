<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Dto\QuestionsGroup\Request;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto as AppQuestionCreateDto;

// TODO: Connect method to code...
class QuestionCreateDto extends AppQuestionCreateDto
{
    public function convertToArray(): array
    {
        return [
            'uuid' => $this->uuid->toRfc4122(),
            'text' => $this->text,
            'explanation' => $this->explanation ?? null,
            'points' => $this->points ?? null,
            'orderIndex' => $this->orderIndex ?? null,
            'settings' => $this->settings ?? null,
        ];
    }
}
