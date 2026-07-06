<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Trait;

use App\Domain\Topic\Entity\TopicEntity;
use App\Domain\Topic\Enum\TopicTypeEnum;
use Symfony\Component\Uid\Uuid;

trait TopicDatabaseMapperTrait
{
    protected function mapToEntity(object $row): TopicEntity
    {
        return new TopicEntity(
            id: (int)$row->id,
            entityId: $row->entity_id ? Uuid::fromString($row->entity_id) : null,
            orderIndex: $row->index_number,
            type: TopicTypeEnum::from($row->name),
            moduleId: $row->stage_id,
            passedTopics: $row->passed_topics
                ? explode(',', $row->passed_topics)
                : null,
        );
    }

    protected function mapToArray(TopicEntity $lesson): array
    {
        return [
            'entity_id' => $lesson->getEntityId(),
            'index_number' => $lesson->getOrderIndex(),
            'name' => $lesson->getType()->value,
            'stage_id' => $lesson->getModuleId(),
            'passed_topics' => $lesson->getPassedTopics(),
        ];
    }
}
