<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Domain\Quiz\Entity\QuizEntity;
use App\Domain\Quiz\Repository\QuizRepositoryInterface;
use App\Infrastructure\Persistence\Trait\QuizDatabaseMapperTrait;
use Illuminate\Database\DatabaseManager;
use stdClass;

readonly class QuizRepository implements QuizRepositoryInterface
{
    use QuizDatabaseMapperTrait;

    public function __construct(
        private DatabaseManager $db
    ) {
    }

    public function findByTopicId(int $topicId): ?QuizEntity
    {
        $quizRow = $this->db->connection(config('database.default'))
            ->table('lms_quizzes')
            ->leftJoin('lms_topics', 'lms_quizzes.topic_id', '=', 'lms_topics.id')
            ->where('lms_quizzes.topic_id', $topicId)
            ->whereNull('lms_quizzes.deleted_at')
            ->select([
                'lms_quizzes.*',
                'lms_topics.stage_id as module_id',
                'lms_topics.index_number as order_index',
            ])
            ->first();

        return $quizRow ? $this->mapToEntity($quizRow) : null;
    }

    /**
     * @param int[] $topicIds
     * @return array<int, QuizEntity>
     */
    public function findByTopicIds(array $topicIds): array
    {
        if (empty($topicIds)) {
            return [];
        }

        $rows = $this->db->connection(config('database.default'))
            ->table('lms_quizzes')
            ->leftJoin('lms_topics', 'lms_quizzes.topic_id', '=', 'lms_topics.id')
            ->whereIn('topic_id', $topicIds)
            ->whereNull('lms_quizzes.deleted_at')
            ->select([
                'lms_quizzes.*',
                'lms_topics.stage_id as module_id',
                'lms_topics.index_number as order_index',
            ])
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $result[(int)$row->topic_id] = $this->mapToEntity($row);
        }

        return $result;
    }

    public function getQuizzesChunk(int $batchSize, int $offset = 0): array
    {
        $quizRows = $this->db->connection(config('database.default'))
            ->table('lms_quizzes')
            ->leftJoin('lms_topics', 'lms_quizzes.topic_id', '=', 'lms_topics.id')
            ->whereNull('lms_quizzes.deleted_at')
            ->whereNull('lms_topics.entity_id')
            ->select([
                'lms_quizzes.*',
                'lms_topics.stage_id as module_id',
                'lms_topics.index_number as order_index',
            ])
            ->orderBy('lms_quizzes.id')
            ->limit($batchSize)
            ->offset($offset)
            ->get()
            ->toArray();

        return array_map(
            callback: fn(stdClass $quizRow) => $this->mapToEntity($quizRow),
            array: $quizRows
        );
    }

    public function getTotalUnmigrated(): int
    {
        return $this->db->connection('mysql')
            ->table('lms_quizzes')
            ->join('lms_topics', 'lms_quizzes.topic_id', '=', 'lms_topics.id')
            ->whereNull('lms_quizzes.deleted_at')
            ->whereNull('lms_topics.entity_id')
            ->count();
    }
}
