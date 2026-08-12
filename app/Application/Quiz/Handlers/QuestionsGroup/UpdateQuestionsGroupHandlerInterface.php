<?php
declare (strict_types=1);

namespace App\Application\Quiz\Handlers\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupUpdateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;

interface UpdateQuestionsGroupHandlerInterface
{
    public function handle(
        string $uuid,
        QuestionsGroupUpdateDto $requestDto
    ): QuestionsGroupDto;
}
