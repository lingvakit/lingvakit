<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

use Symfony\Component\Uid\Uuid;

class MultipleChoiceHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'multiple_choice';
    }

    public function handle(object $conformityRow, iterable $optionRows): array
    {
        $options = [];
        $answer = null;

        foreach ($optionRows as $optionRow) {
            $uuid = Uuid::v4()->toRfc4122();

            $options[] = [
                'uuid' => $uuid,
                'text' => $optionRow->value,
            ];

            if ($optionRow->is_correct) {
                $answer['value'][] = $uuid;
            }
        }

        return [
            'options' => $options,
            'answer' => $answer,
        ];
    }
}
