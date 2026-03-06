<?php
declare(strict_types=1);

namespace App\Application\Course\Dto\Course;

final readonly class CourseModuleDto
{
    public function __construct(
        private int $id,
        private string $title,

        /** @var array<CourseTopicDto> */
        private ?array $topics = [],
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTopics(): ?array
    {
        return $this->topics;
    }
}