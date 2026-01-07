<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

use Symfony\Component\Uid\Uuid;

class FillInBlankHandler implements QuestionHandlerInterface
{
    public function supports(string $type): bool
    {
        return $type === 'fill_in_blank';
    }

    public function handle(object $conformityRow, iterable $optionRows): array
    {
        $answer = null;
        $options = [];
        $answersByGap = [];

        foreach ($optionRows as $optionRow) {
            $uuid = Uuid::v4()->toRfc4122();

            $options[] = [
                'uuid' => $uuid,
                'text' => $optionRow->value,
            ];

            if ($optionRow->is_correct) {
                $gap = (int) $conformityRow->word_number;
                $answersByGap[$gap][] = $uuid;
            }
        }

        if ($answersByGap !== []) {
            $answer = [
                'value' => array_map(
                    static fn (int $gap, array $uuids) => [
                        'gap' => $gap,
                        'answers' => $uuids,
                    ],
                    array_keys($answersByGap),
                    $answersByGap
                ),
            ];
        }

        return [
            'options' => $options,
            'answer' => $answer,
        ];
    }
}
