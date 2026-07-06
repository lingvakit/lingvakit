<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy\QuestionMappingStrategyInterface;
use Log;

class LegacyQuestionAggregateFactory
{
    /** @var QuestionMappingStrategyInterface[] */
    private array $strategies;

    public function __construct(iterable $strategies)
    {
        $this->strategies = iterator_to_array($strategies);
    }

    public function buildAggregates(array $legacyQuestions, array $conformities, array $options): array
    {
        $groups = [];

        foreach ($legacyQuestions as $legacyQuestion) {
            $strategy = $this->resolveStrategy($legacyQuestion->type);

            if ($strategy) {
                $groups[] = $strategy->map($legacyQuestion, $conformities, $options);
            } else {
                Log::warning("Strategy for the question type {$legacyQuestion->type} not found.");
            }
        }

        return $groups;
    }

    private function resolveStrategy(string $legacyType): ?QuestionMappingStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($legacyType)) {
                return $strategy;
            }
        }

        return null;
    }
}
