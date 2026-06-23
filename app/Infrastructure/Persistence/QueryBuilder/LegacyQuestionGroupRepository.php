<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Domain\Quiz\Repository\LegacyQuestionGroupRepositoryInterface;
use Illuminate\Database\DatabaseManager;

readonly class LegacyQuestionGroupRepository implements LegacyQuestionGroupRepositoryInterface
{
    public function __construct(
        private DatabaseManager $db,
        private LegacyQuestionAggregateFactory $aggregateFactory,
    ) {
    }

    public function getGroupsForQuiz(int $quizId): array
    {
        $legacyQuestions = $this->db->connection(config('database.default'))
            ->table('lms_questions')
            ->select([
                'lms_questions.*',
                'audio' => $this->db->connection(config('database.default'))
                    ->table('lms_question_audios')
                    ->whereColumn('lms_question_audios.question_id', 'lms_questions.id')
                    ->orderBy('lms_question_audios.id')
                    ->select('lms_question_audios.audio')
                    ->limit(1)
            ])
            ->where('quiz_id', $quizId)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        if (empty($legacyQuestions)) {
            return [];
        }

        $legacyQuestionIds = array_column($legacyQuestions, 'id');

        $conformities = $this->db->connection(config('database.default'))
            ->table('lms_conformity')
            ->whereIn('question_id', $legacyQuestionIds)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        $conformityIds = array_column($conformities, 'id');
        $options = [];

        if (!empty($conformityIds)) {
            $options = $this->db->connection(config('database.default'))
                ->table('lms_conformity_options')
                ->whereIn('conformity_id', $conformityIds)
                ->get()
                ->toArray();
        }

        return $this->aggregateFactory->buildAggregates($legacyQuestions, $conformities, $options);
    }
}
