<?php

declare(strict_types=1);

namespace App\Infrastructure\MS\Quiz;

readonly class QuestionGateway
{
    public function __construct(
        private QuizClient $client
    ) {
    }

    public function getQuestionDataFromMs(string $uuid): array
    {
        return $this->client->getQuestion($uuid);
    }

    public function createQuestionInMs(array $data, string $quizUuid): string
    {
        try {
            $uuid = $this->client->createQuestion([
                'quizUuid' => $quizUuid,
                'text' => $data['title'],
                'type' => 'single_choice',
                'explanation' => $data['explanation'],
                'orderIndex' => null,
                'meta' => [],
                'options' => [
                    [
                        'text' => 'Ans 1',
                        'orderIndex' => null,
                        'isCorrect' => false,
                    ],
                    [
                        'text' => 'Ans 2',
                        'orderIndex' => null,
                        'isCorrect' => true,
                    ],
                ],
            ]);
        } catch (\Throwable $exception) {
            throw new \Exception('Error: ' . $exception->getMessage());
        }

        return $uuid;
    }
}