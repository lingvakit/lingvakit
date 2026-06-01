<?php
declare(strict_types=1);

namespace App\Application\Media\Handlers;

use App\Application\Media\Dto\MediaFileCreateRequestDto;
use App\Application\Media\Dto\MediaFileDto;
use App\Application\Media\Helper\MediaFileHelper;
use App\Application\Media\Mapper\MediaFileMapper;
use App\Infrastructure\Persistence\Repository\MediaFileRepositoryInterface;
use App\Integration\Media\Client\MediaClientInterface;
use App\Integration\Media\Exception\MediaFileUploadFailedException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

final readonly class UploadMediaFileHandler implements UploadMediaFileHandlerInterface
{
    public function __construct(
        private MediaClientInterface $client,
        private MediaFileRepositoryInterface $repository,
        private MediaFileMapper $mapper,
        private MediaFileHelper $helper,
    ) {
    }

    public function handle(
        UploadedFile $file,
        ?MediaFileCreateRequestDto $dto = null
    ): MediaFileDto {
        return DB::transaction(function () use ($file, $dto) {
            try {
                $responseDto = $this->client->uploadFile($file);
            } catch (MediaFileUploadFailedException $e) {
                throw new MediaFileUploadFailedException(
                    message: "Failed to upload file",
                    previous: $e->getPrevious()
                );
            }

            $uploadedFileData = $this->helper->prepareFileMetaDtoFromUploadedFile(
                $responseDto->url,
                $file
            );

            $mediaFileData = array_merge(
                $dto->convertToArray(),
                $uploadedFileData->toArray()
            );

            $mediaFile = $this->repository->findByFilenameAndPath(
                $uploadedFileData->filename,
                $uploadedFileData->path
            );

            if (!$mediaFile) {
                $mediaFile = $this->repository->save($mediaFileData);
            }

            return $this->mapper->fromModel($mediaFile);
        });

    }
}
