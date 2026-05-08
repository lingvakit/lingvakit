<?php
declare (strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;

interface CreateQuestionsGroupHandlerInterface
{
    public function handle(QuestionsGroupCreateDto $requestDto): QuestionsGroupDto;
}
