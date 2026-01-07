<?php

declare(strict_types=1);

namespace App\Console\Commands\QuizMigrate;

use App\Infrastructure\MS\Quiz\QuestionGateway;
use App\Infrastructure\MS\Quiz\QuestionGroupGateway;
use App\Infrastructure\MS\Quiz\QuizGateway;
use App\Models\LMS\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Uuid;

class QuizMigrateCommand extends Command
{
    protected $signature = 'quiz:migrate
        {--dry-run : Do not send data, only show what will be migrated}
        {--force : Allow running in production}';

    protected $description = 'Migrate quiz data from Laravel to Quiz MS';

    public function __construct(
        private readonly QuizGateway $quizGateway,
        private readonly QuestionGroupGateway $groupGateway,
        private readonly QuestionGateway $questionGateway,
        private readonly QuestionPayloadBuilder $questionPayloadBuilder,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        // Protection for production
        if (app()->environment('production') && !$this->option('force')) {
            $this->error('Migration is disabled in production without --force option.');
            return self::FAILURE;
        }

        $dryRun = (bool)$this->option('dry-run');

        $this->info('Starting quiz migration...');

        DB::table('lms_quizzes')
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->chunkById(50, function ($quizzes) use ($dryRun) {
                foreach ($quizzes as $quizRow) {
                    if (!$quizRow->uuid) {
                        DB::table('lms_quizzes')
                            ->where('id', $quizRow->id)
                            ->update([
                            'uuid' => Uuid::v4(),
                        ]);
                    }

                    $quiz = $this->mapQuizRow($quizRow);

                    if ($dryRun) {
                        $this->line('DRY RUN: ' . $quiz['title']);
                        continue;
                    }

                    $quizUuid = $this->quizGateway->storeInMs($quiz);

                    $this->migrateQuestionGroups($quiz['id'], $quizUuid, $dryRun);
                }
            });

        return self::SUCCESS;
    }

    private function mapQuizRow(object $row): array
    {
        return [
            'id' => $row->id,
            'uuid' => $row->uuid,
            'title' => $row->title,
            'description' => $row->description ?: null,
            'image' => $this->normalizeInt($row->image),
            'audio' => $this->normalizeInt($row->audio),
            'video' => $this->normalizeInt($row->video),
            'duration' => $row->duration ? (int)$row->duration : null,
            'passing_score' => $row->passing_score ? (int)$row->passing_score : null,
        ];
    }

    private function migrateQuestionGroups(int $quizId, string $quizUuid, bool $dryRun): void
    {
        DB::table('lms_questions')
            ->whereNull('deleted_at')
            ->where('quiz_id', $quizId)
            ->orderBy('id')
            ->chunkById(50, function ($questions) use ($quizUuid, $dryRun) {
                foreach ($questions as $questionRow) {
                    $groupPayload = [
                        'quizUuid' => $quizUuid,
                        'title' => $questionRow->title,
                        'imageId' => $questionRow->image,
                        'type' => QuestionTypeMapper::MAP[$questionRow->type],
                        'description' => $questionRow->explanation,
                        'fontSize' => $questionRow->font_size,
                    ];

                    if ($dryRun) {
                        $this->line('DRY RUN QUESTION GROUPS: ' . count($groupPayload['questions']));
                        return;
                    }

                    $groupUuid = $this->groupGateway->storeInMs($groupPayload);

                    $this->migrateQuestions(
                        groupId: $questionRow->id,
                        groupUuid: $groupUuid,
                        questionType: QuestionTypeMapper::MAP[$questionRow->type],
                        dryRun: $dryRun
                    );
                }
            });
    }

    private function migrateQuestions(int $groupId, string $groupUuid, string $questionType, bool $dryRun): void
    {
        DB::table('lms_conformity')
            ->whereNull('deleted_at')
            ->where('question_id', $groupId)
            ->orderBy('id')
            ->chunkById(50, function ($conformities) use ($groupId, $groupUuid, $questionType, $dryRun) {
                if ($questionType !== 'match') {
                    foreach ($conformities as $conformityRow) {
                        $payload = $this->questionPayloadBuilder->build(
                            conformityRow: $conformityRow,
                            groupUuid: $groupUuid,
                            questionType: $questionType
                        );

                        if ($questionType === 'fill_in_blank') {
                            $payload['title'] = $this->fixFillInBlankText(
                                originText: $payload['title'],
                                wordNumber: (int)$payload['wordNumber']
                            );
                        }

                        $this->questionGateway->storeInMs($payload);
                    }

                    return;
                }

                $answer = [];
                $matchKey = 0;
                foreach ($conformities as $conformityRow) {
                    $matchKey++;
                    $uuid = Uuid::v4()->toRfc4122();

                    $payload = $this->questionPayloadBuilder->build(
                        conformityRow: $conformityRow,
                        groupUuid: $groupUuid,
                        questionType: $questionType
                    );

                    // Change title
                    $payload['title'] = Question::find($groupId)->title;

                    // Add left option
                    $payload['options'][] = [
                        'uuid' => Uuid::v4()->toRfc4122(),
                        'text' => $conformityRow->title,
                        'matchKey' => $matchKey,
                    ];

                    foreach ($payload['options'] ?? [] as $key => $option) {
                        if (in_array($option['uuid'], $payload['answer']['extraAnswers'])) {
                            continue;
                        }

                        if (!isset($option['matchKey'])) {
                            $payload['options'][$key]['matchKey'] = $matchKey;
                        }
                    }

                    // Add answer
                    $tempAnswer = $payload['answer'];

                    $answer['value']['left'][] = $uuid;
                    $answer['value']['right'][] = $tempAnswer['rightAnswers'];
                    $answer['value']['pairs'][$uuid] = array_diff(
                        $tempAnswer['rightAnswers'],
                        $tempAnswer['extraAnswers']
                    );

                    $payload['answer'] = $answer;

                    $this->questionGateway->storeInMs($payload);
                }
            });
    }

    private function fixFillInBlankText(string $originText, int $wordNumber): string
    {
        $textArray = explode(" ", $originText);

        array_splice(
            array: $textArray,
            offset: $wordNumber - 1,
            length: 0,
            replacement: "___"
        );

        return implode(" ", $textArray);
    }

    private function normalizeInt(?string $value): ?int
    {
        $value = trim((string)$value);

        return ($value !== '' && is_numeric($value) && (int)$value > 0) ? (int)$value : null;
    }
}
