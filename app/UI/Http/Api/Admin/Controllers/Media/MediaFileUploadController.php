<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Media;

use App\Application\Media\Handlers\UploadMediaFileHandlerInterface;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\MediaFile\MediaFileRequest;
use App\UI\Http\Api\Admin\Resources\MediaFile\MediaFileDetailsResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MediaFileUploadController extends Controller
{
    public function __construct(
        private readonly UploadMediaFileHandlerInterface $handler
    ) {
    }

    public function __invoke(MediaFileRequest $request): JsonResponse
    {
        $file = $request->file('file');
        $mediaFileDto = $this->handler->handle($file, $request->dto());

        return response()->json(
            data: new MediaFileDetailsResource($mediaFileDto),
            status: Response::HTTP_CREATED
        );
    }
}
