<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Domain\Quiz\Entity\QuizEntity;
use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\Response\QuizDto;

interface QuizServiceInterface
{
    public function getDataByUuid(string $uuid): QuizDto;

    /**
     * @param string[] $topicEntityIds
     * @return array<string, QuizEntity>
     */
    public function getBatchDataByUuids(array $topicEntityIds): array;
    public function create(QuizCreateRequestDto $dto): QuizDto;
}
