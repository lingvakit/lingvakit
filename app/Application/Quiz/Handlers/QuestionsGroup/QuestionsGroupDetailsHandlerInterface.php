<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\QuestionsGroup;

use App\Application\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;

interface QuestionsGroupDetailsHandlerInterface
{
    public function handle(string $groupUuid): QuestionsGroupDto;
}
