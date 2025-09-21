<?php

namespace App\Console\Commands;

use App\Models\MediaFile;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MigrateFileCommand extends Command
{
    protected $signature = 'files:migrate';
    protected $description = 'Command description';

    private const array SKIPPED_EXTENSIONS = ['bin'];

    private const array TYPE_MAP = [
        'file' => 'document',
    ];

    public function handle(): int
    {
        $msUrl = config('app.url') . config('services.ms.media');

        $mediaFiles = MediaFile::all();
        foreach ($mediaFiles as $file) {
            try {
                if ($this->shouldSkip($file->filename)) {
                    $this->warn("Skipped: {$file->filename}");
                    continue;
                }

                $url = $this->buildUrl($msUrl, $file);

                $this->migrateFile($file, $url);
            } catch (Exception $e) {
                $this->error("Error processing {$file->filename}: {$e->getMessage()}");
                continue;
            }
        }

        return Command::SUCCESS;
    }

    private function shouldSkip(string $filename): bool
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return in_array(strtolower($ext), self::SKIPPED_EXTENSIONS, true);
    }

    private function buildUrl(string $msUrl, MediaFile $file): string
    {
        $type = self::TYPE_MAP[$file->type] ?? $file->type;

        $path = preg_replace('/id_(\d+)/', 'id$1', $file->path);
        $path = str_replace('/', '_', $path);

        return "{$msUrl}/{$type}/{$path}/{$file->filename}";
    }

    private function migrateFile(MediaFile $file, string $url): void
    {
        $response = Http::post($url, []);
        $data = $response->json();

        if (!isset($data['url'])) {
            $this->warn("No URL returned for: $url");
            return;
        }

        $newPath = $data['url'];
        $partsArray = explode('/', $newPath);

        $filename = array_pop($partsArray);
        $path = implode('/', $partsArray);

        $file->update([
            'filename' => $filename,
            'path' => $path,
        ]);

        $this->info("Migrated URL: {$data['url']}");
    }
}
