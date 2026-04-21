<?php
declare(strict_types=1);

namespace App\Application\Topic\Mapper;

use App\Application\Quiz\Mapper\QuizMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Domain\Topic\Enum\TopicTypeEnum;
use App\Integration\Quiz\Dto\QuizResponseDto;
use App\Models\LMS\Topic;

final readonly class TopicQuizMapper
{
    public function __construct(
        private QuizMapper $quizMapper,
    ) {
    }

    public function fromModel(Topic $topic, QuizResponseDto $quizResponseDto): TopicDto
    {
        return new TopicDto(
            id: $topic->id,
            type: TopicTypeEnum::from($topic->name),
            orderIndex: $topic->index_number,
            quiz: $this->quizMapper->fromMsResponse($quizResponseDto)
        );
    }
}
