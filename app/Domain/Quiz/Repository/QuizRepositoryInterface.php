<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Repository;

use App\Domain\Quiz\Entity\QuizEntity;

interface QuizRepositoryInterface
{
    public function findByTopicId(int $topicId): ?QuizEntity;

    /**
     * @param int[] $topicIds
     * @return array<int, QuizEntity>
     */
    public function findByTopicIds(array $topicIds): array;

    public function getQuizzesChunk(int $batchSize, int $offset = 0): array;
    public function getTotalUnmigrated(): int;
}
