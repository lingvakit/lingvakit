<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\QueryBuilder;

use App\Domain\Lesson\Entity\LessonEntity;
use App\Domain\Lesson\Repository\LessonRepositoryInterface;
use App\Infrastructure\Persistence\Trait\LessonDatabaseMapperTrait;
use Illuminate\Database\DatabaseManager;

readonly class LessonRepository implements LessonRepositoryInterface
{
    use LessonDatabaseMapperTrait;

    public function __construct(
        private DatabaseManager $db,
    ){
    }

    public function findById(int $id): ?LessonEntity
    {
        // TODO: Implement findById() method.
    }

    public function findByTopicId(int $topicId): ?LessonEntity
    {
        // TODO: Implement findByTopicId() method.
    }

    /**
     * @param int[] $topicIds
     * @return array<int, LessonEntity>
     */
    public function findByTopicIds(array $topicIds): array
    {
        if (empty($topicIds)) {
            return [];
        }

        $rows = $this->db->connection(config('database.default'))
            ->table('lms_lessons')
            ->whereIn('topic_id', $topicIds)
            ->whereNull('deleted_at')
            ->get();

        $result = [];
        foreach ($rows as $row) {
            $result[(int)$row->topic_id] = $this->mapToEntity($row);
        }

        return $result;
    }

    public function save(LessonEntity $lesson): LessonEntity
    {
        // TODO: Implement save() method.
    }

    public function update(LessonEntity $lesson): LessonEntity
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}