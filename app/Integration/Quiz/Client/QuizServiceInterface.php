<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Integration\Quiz\Dto\Request\Quiz\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\Response\QuizDto;

interface QuizServiceInterface
{
    public function getDataByUuid(string $uuid): QuizDto;
    public function create(QuizCreateRequestDto $dto): QuizDto;
}
