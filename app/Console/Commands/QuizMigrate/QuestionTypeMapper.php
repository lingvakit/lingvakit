<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate;

use InvalidArgumentException;

final class QuestionTypeMapper
{
    public const array MAP = [
        'single_choice' => 'single_choice',
        'multiple_choice' => 'multiple_choice',
        'logic_choice' => 'boolean',
        'fill_the_gaps' => 'fill_in_blank',
        'matching' => 'match',
        'make_sentence' => 'sentence_build',
        'make_text' => 'sentence_build',
        'short_answer' => 'free_text',
        'listen_write' => 'free_text',
    ];

    public function map(string $legacyType): string
    {
        if (!isset(self::MAP[$legacyType])) {
            throw new InvalidArgumentException("Unknown question type: $legacyType");
        }

        return self::MAP[$legacyType];
    }
}