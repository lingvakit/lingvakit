<?php
declare(strict_types=1);

namespace App\Application\Quiz\Handlers\Question;

use App\Application\Quiz\Dto\Question\QuestionDto;
use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionCreateDto;

interface CreateQuestionHandlerInterface
{
    public function handle(QuestionCreateDto $requestDto): QuestionDto;
}
