<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers;

use App\Application\Quiz\Dto\Response\QuizDto;
use App\Application\Quiz\Mapper\QuizMapper;
use App\Integration\Quiz\Client\QuizClient;

readonly class QuizDetailsHandler implements QuizDetailsHandlerInterface
{
    public function __construct(
        private QuizClient $quizClient,
        private QuizMapper $quizMapper
    ) {
    }

    public function handle(string $quizUuid): QuizDto
    {
        $quizMsResponseDto = $this->quizClient->getDataByUuid($quizUuid);

        return $this->quizMapper->fromMsResponse($quizMsResponseDto);
    }
}
