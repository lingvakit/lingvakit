<?php
declare(strict_types=1);

namespace App\Domain\Quiz\Repository;

interface LegacyQuestionGroupRepositoryInterface
{
    public function getGroupsForQuiz(int $quizId): array;
}
