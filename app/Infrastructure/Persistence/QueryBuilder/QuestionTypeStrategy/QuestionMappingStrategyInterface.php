<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder\QuestionTypeStrategy;

use App\Domain\Quiz\Entity\QuestionGroupEntity;

interface QuestionMappingStrategyInterface
{
    public function supports(string $legacyType): bool;
    public function map(object $legacyQuestion, array $conformities, array $options): QuestionGroupEntity;
}
