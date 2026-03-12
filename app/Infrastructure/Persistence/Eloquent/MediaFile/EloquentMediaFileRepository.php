<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\MediaFile;

use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Enum\FileType;
use App\Application\Media\ReadModel\MediaFileRepository;
use App\Models\MediaFile;
use Illuminate\Pagination\AbstractPaginator;

class EloquentMediaFileRepository implements MediaFileRepository
{
    public function paginate(int $perPage = 20, string $search = ''): AbstractPaginator
    {
        $query = MediaFile::query()
            ->select([
                'id',
                'filename',
                'path',
                'type'
            ])
            ->orderByDesc('created_at');

        if ($search !== '') {
            $query->where('filename', 'like', "%{$search}%");
        }

        return $query->paginate($perPage)->through(
            fn (MediaFile $mediaFile) => new MediaFileDto(
                id: $mediaFile->id,
                fileName: $mediaFile->filename,
                url: $mediaFile->getPath(),
                type: FileType::from($mediaFile->type),
            )
        );
    }
}
