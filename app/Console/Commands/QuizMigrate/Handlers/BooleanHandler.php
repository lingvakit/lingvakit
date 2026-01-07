<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

use Symfony\Component\Uid\Uuid;

class BooleanHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'boolean';
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

            $answer['value'] = (bool)$optionRow->is_correct;
        }

        return [
            'options' => $options,
            'answer' => $answer,
        ];
    }
}
