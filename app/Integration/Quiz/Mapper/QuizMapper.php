<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Mapper;

use App\Domain\Quiz\Enum\QuizStatusEnum;
use App\Integration\Quiz\Dto\Response\QuizDto;

readonly class QuizMapper
{
    public function __construct(
        private QuestionsGroupMapper $questionsGroupMapper,
    ){
    }

    public function fromResponseDataToDto(array $data): QuizDto
    {
        return new QuizDto(
            uuid: $data['uuid'],
            title: $data['title'],
            description: $data['description'] ?? null,
            imageId: $data['imageId'] ?? null,
            audioId: $data['audioId'] ?? null,
            videoId: $data['videoId'] ?? null,
            timeLimit: $data['timeLimit'],
            passingScore: $data['passingScore'],
            status: QuizStatusEnum::from($data['status']),
            questionGroups: array_map(
                fn($groupData) => $this->questionsGroupMapper->fromResponseDataToDto($groupData),
                $data['currentVersion']['questionGroups'] ?? []
            ),
        );
    }

    /**
     * @param array $dataList
     * @return array<string, QuizDto>
     */
    public function fromResponseDataToDtoArray(array $dataList): array
    {
        $list = [];
        foreach ($dataList as $data) {
            $list[$data['uuid']] = $this->fromResponseDataToDto($data);
        }

        return $list;
    }
}
