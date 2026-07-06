<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Topic;

use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Repository\TopicRepositoryInterface;
use App\Infrastructure\Persistence\Trait\TopicDatabaseMapperTrait;
use App\Models\LMS\Topic;

class EloquentTopicRepository implements TopicRepositoryInterface
{
    use TopicDatabaseMapperTrait;

    public function findById(int $id): ?TopicEntity
    {
        $topic = Topic::find($id);

        return $topic ? $this->mapToEntity($topic) : null;
    }

    public function findByEntityId(string $entityId): ?TopicEntity
    {
        $topic = Topic::where('entity_id', $entityId)->first();

        return $topic ? $this->mapToEntity($topic) : null;
    }

    public function save(TopicEntity $topic): TopicEntity
    {
        $data = $this->mapToArray($topic);
        $topicModel = Topic::create($data);

        return $this->mapToEntity($topicModel);
    }

    public function update(TopicEntity $topic): TopicEntity
    {
        $data = $this->mapToArray($topic);
        Topic::find($topic->getId())?->update($data);

        return $topic;
    }

    public function updateEntityId(int $topicId, string $quizUuid): void
    {
        Topic::find($topicId)?->update([
            'entity_id' => $quizUuid
        ]);
    }

    public function delete(int $id): void
    {
        Topic::find($id)?->delete();
    }
}
