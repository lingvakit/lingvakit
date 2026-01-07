<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate;

use App\Console\Commands\QuizMigrate\Handlers\QuestionHandlerInterface;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final readonly class QuestionPayloadBuilder
{
    /** @param iterable<QuestionHandlerInterface> $handlers */
    public function __construct(
        private iterable $handlers
    ) {
    }

    public function build(object $conformityRow, string $groupUuid, string $questionType): array
    {
        $optionRows = DB::table('lms_conformity_options')
            ->whereNull('deleted_at')
            ->where('conformity_id', $conformityRow->id)
            ->orderBy('id')
            ->get();

        foreach ($this->handlers as $handler) {
            if ($handler->supports($questionType)) {
                $result = $handler->handle($conformityRow, $optionRows);

                return [
                    'groupUuid' => $groupUuid,
                    'title' => $conformityRow->title,
                    'imageId' => $this->normalizeInt($conformityRow->image),
                    'audioId' => $this->normalizeInt($conformityRow->audio),
                    'wordNumber' => $conformityRow->word_number,
                    'points' => $conformityRow->points,
                    'type' => $questionType,
                    'options' => $result['options'],
                    'answer' => $result['answer'],
                ];
            }
        }

        throw new RuntimeException("No handler for type $questionType");
    }

    private function normalizeInt(?string $value): ?int
    {
        $value = trim((string)$value);

        return ($value !== '' && is_numeric($value) && (int)$value > 0) ? (int)$value : null;
    }
}