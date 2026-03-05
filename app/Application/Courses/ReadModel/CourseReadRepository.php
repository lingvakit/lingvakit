<?php
declare(strict_types=1);

namespace App\Application\Courses\ReadModel;

use App\Application\Courses\Dto\CourseDetailsDto;
use App\Application\Courses\Dto\CourseListItemDto;
use Illuminate\Pagination\AbstractPaginator;

interface CourseReadRepository
{
    /** @return AbstractPaginator<CourseListItemDto> */
    public function paginate(int $perPage, string $search): AbstractPaginator;
    public function getById(int $id): CourseDetailsDto;
}