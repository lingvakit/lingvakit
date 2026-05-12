<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Integration\Quiz\Dto\QuestionsGroup\Response\QuestionsGroupDto;

interface QuestionsGroupServiceInterface
{
    public function create(
        QuestionsGroupCreateDto $requestDto
    ): QuestionsGroupDto;
}
