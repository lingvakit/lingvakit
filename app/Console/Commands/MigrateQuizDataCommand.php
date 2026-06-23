<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Application\Quiz\UseCase\MigrateQuizDataUseCase;
use App\Domain\Quiz\Repository\QuizRepositoryInterface;
use Illuminate\Console\Command;

class MigrateQuizDataCommand extends Command
{
    protected $signature = 'quiz:migrate
        {--batch-size=100 : Data chunk size for processing}
        {--limit= : Limit on the number of records to be processed}
        {--offset=0 : Processing start offset}';

    protected $description = 'Quizzes data migration from a Laravel monolith to a Quiz microservice';

    public function __construct(
        private readonly QuizRepositoryInterface $quizRepository,
        private readonly MigrateQuizDataUseCase $useCase,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $batchSize = (int) $this->option('batch-size');
        $limit = (int) $this->option('limit');

        $this->info("Quiz migration started. Batch size: {$batchSize}");

        $totalToProcess = $this->quizRepository->getTotalUnmigrated();

        if ($totalToProcess === 0) {
            $this->info("No data for migration. All of quizzes almost migrated.");
            return self::SUCCESS;
        }

        if ($limit > 0 && $limit < $totalToProcess) {
            $totalToProcess = $limit;
        }

        $bar = $this->output->createProgressBar($totalToProcess);
        $bar->start();

        $totalProcessed = 0;
        $totalFailed = 0;

        while (true) {
            if ($limit > 0 && ($totalProcessed + $totalFailed) >= $limit) {
                break;
            }

            $result = $this->useCase->execute($batchSize);

            if ($result['processed'] === 0 && $result['failed'] === 0) {
                break;
            }

            $totalProcessed += $result['processed'];
            $totalFailed += $result['failed'];

            $bar->advance($result['processed'] + $result['failed']);
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Migration is finished. Success: {$totalProcessed}, Errors: {$totalFailed}");

        if ($totalFailed > 0) {
            $this->warn("Migration has errors. Please, check log files for details.");
        }

        return self::SUCCESS;
    }
}
