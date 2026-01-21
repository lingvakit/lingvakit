<?php

declare(strict_types=1);

namespace App\Application\Quiz\Enum;

enum QuestionType: string
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';

    public function getCreateViewName(): string
    {
        return match ($this) {
            self::SingleChoice => 'cms.courses.quizzes.question-groups.single-choice.create',
            default => 'cms.courses.quizzes.questions.create',
        };
    }

    public function getValue(): string
    {
        return match ($this) {
            self::SingleChoice => 'Одиночный выбор',
            default => '',
        };
    }
}
