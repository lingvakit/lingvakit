<?php

namespace App\Integration\Quiz\Exception;

use Throwable;

class QuizDataFailedException extends \RuntimeException
{
    public function __construct(
        string $message = "Getting quiz data is failed",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}