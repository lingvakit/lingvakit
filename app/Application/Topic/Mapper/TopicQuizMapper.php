<?php
declare(strict_types=1);

namespace App\Application\Topic\Mapper;

use App\Application\Quiz\Mapper\QuizMapper;
use App\Application\Topic\Dto\TopicDto;
use App\Domain\Topic\Entity\TopicQuizEntity;
use App\Integration\Quiz\Dto\Response\QuizDto;

final readonly class TopicQuizMapper
{
    public function __construct(
        private QuizMapper $quizMapper,
    ) {
    }

    public function fromEntity(TopicQuizEntity $topic, QuizDto $quizResponseDto): TopicDto
    {
        return new TopicDto(
            id: $topic->getId(),
            type: $topic->getType(),
            orderIndex: $topic->getOrderIndex(),
            quiz: $this->quizMapper->fromMsResponse($quizResponseDto)
        );
    }
}
