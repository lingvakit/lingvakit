<?php
declare (strict_types = 1);

namespace App\Integration\Quiz\Exception;

use Throwable;

class QuestionsGroupCreateFailedException extends QuizClientException
{
    public function __construct(
        string $message = "Questions group creation failed",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
