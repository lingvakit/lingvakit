<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate\Handlers;

interface QuestionHandlerInterface
{
    public function supports(string $type): bool;

    /**
     * @param object $conformityRow
     * @param iterable $options
     *
     * @return array{
     *     options: array,
     *     answer: array|null
     * }
     */
    public function handle(object $conformityRow, iterable $optionRows): array;
}