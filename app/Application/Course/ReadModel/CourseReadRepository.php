<?php
declare(strict_types=1);

namespace App\Application\Course\ReadModel;

use App\Application\Course\Dto\CourseDetailsDto;
use App\Application\Course\Dto\CourseListItemDto;
use Illuminate\Pagination\AbstractPaginator;

interface CourseReadRepository
{
    /** @return AbstractPaginator<CourseListItemDto> */
    public function paginate(int $perPage, string $search): AbstractPaginator;
    public function getById(int $id): CourseDetailsDto;
}