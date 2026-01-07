<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

use Symfony\Component\Uid\Uuid;

class MatchHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'match';
    }

    public function handle(object $conformityRow, iterable $optionRows): array
    {
        $options = [];
        $rightAnswers = [];
        $extraAnswers = [];

        foreach ($optionRows as $optionRow) {
            $uuid = Uuid::v4()->toRfc4122();

            $options[] = [
                'uuid' => $uuid,
                'text' => $optionRow->value,
            ];

            $rightAnswers[] = $uuid;

            if (!$optionRow->is_correct) {
                $extraAnswers[] = $uuid;
            }
        }

        $answer = [
            'rightAnswers' => $rightAnswers,
            'extraAnswers' => $extraAnswers,
        ];

        return [
            'options' => $options,
            'answer' => $answer,
        ];
    }
}
