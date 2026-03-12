<?php
declare(strict_types=1);

namespace App\UI\Http\Api\Admin\Controllers\Media;

use App\Application\Media\Queries\MediaFileListQuery;
use App\Http\Controllers\Controller;
use App\UI\Http\Api\Admin\Requests\MediaFile\MediaFileListRequest;
use App\UI\Http\Api\Admin\Resources\MediaFile\MediaFileListItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaFileListController extends Controller
{
    public function __construct(
        private readonly MediaFileListQuery $query
    ) {
    }

    public function __invoke(MediaFileListRequest $request): AnonymousResourceCollection
    {
        $paginator = $this->query->handle(
            perPage: 20,
            search: $request->queryString()
        );

         return MediaFileListItemResource::collection($paginator);
    }
}
