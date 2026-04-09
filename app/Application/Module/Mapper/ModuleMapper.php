<?php
declare(strict_types=1);

namespace App\Application\Module\Mapper;

use App\Application\Module\Dto\ModuleDto;
use App\Application\Topic\Mapper\TopicMapper;
use App\Models\LMS\Stage;
use App\Models\LMS\Topic;

final readonly class ModuleMapper
{
    public function __construct(
        private TopicMapper $topicMapper,
    ) {
    }

    public function fromModel(Stage $stage): ModuleDto
    {
        return new ModuleDto(
            id: $stage->id,
            title: $stage->name,
            topics: $stage->topics
                ->map(fn(Topic $topic) => $this->topicMapper->fromModel($topic))
                ->toArray()
        );
    }
}
