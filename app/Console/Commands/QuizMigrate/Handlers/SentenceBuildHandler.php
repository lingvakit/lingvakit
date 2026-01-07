<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

use Symfony\Component\Uid\Uuid;

class SentenceBuildHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'sentence_build';
    }

    public function handle(object $conformityRow, iterable $optionRows): array
    {
        $options = [];
        $words = [];
        $orderIndex = 0;

        foreach ($optionRows as $optionRow) {
            $orderIndex++;
            $uuid = Uuid::v4()->toRfc4122();

            $options[] = [
                'uuid' => $uuid,
                'text' => $optionRow->value,
            ];

            $words[] = [
                'orderIndex' => $orderIndex,
                'uuid' => $uuid
            ];
        }

        return [
            'options' => $options,
            'answer' => ['value' => $words],
        ];
    }
}
