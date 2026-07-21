<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;
use App\Application\Quiz\Mapper\QuestionsGroupMapper;
use App\Integration\Quiz\Client\QuizClient;

readonly class QuestionsGroupDetailsHandler implements QuestionsGroupDetailsHandlerInterface
{
    public function __construct(
        private QuizClient $quizClient,
        private QuestionsGroupMapper $groupMapper,
    ) {
    }

    public function handle(string $groupUuid): QuestionsGroupDto
    {
        $msQuestionsGroupResponseDto = $this->quizClient->getQuestionsGroupDataByUuid($groupUuid);

        return $this->groupMapper->fromMsResponse($msQuestionsGroupResponseDto);
    }
}
