<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Integration\Quiz\Dto\QuizCreateRequestDto;
use App\Integration\Quiz\Dto\QuizResponseDto;

interface QuizServiceInterface
{
    public function getDataByUuid(string $uuid): QuizResponseDto;
    public function create(QuizCreateRequestDto $dto): QuizResponseDto;
}
