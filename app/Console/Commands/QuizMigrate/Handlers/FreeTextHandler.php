<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

class FreeTextHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'free_text';
    }

    public function handle(object $conformityRow, iterable $optionRows): array
    {
        $answer = null;

        foreach ($optionRows as $optionRow) {
            $answer = ['value' => $optionRow->value];
        }

        return [
            'options' => null,
            'answer' => $answer,
        ];
    }
}
