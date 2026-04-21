<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Exception;

use Throwable;

class QuizUpdateFailedException extends QuizClientException
{
    public function __construct(
        string $message = "Quiz update failed",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
