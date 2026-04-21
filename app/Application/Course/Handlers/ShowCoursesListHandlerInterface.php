<?php
declare(strict_types=1);

namespace App\Application\Course\Handlers;

use App\Application\Course\Dto\CourseListItemDto;
use Illuminate\Pagination\AbstractPaginator;

interface ShowCoursesListHandlerInterface
{
    /** @return AbstractPaginator<CourseListItemDto> */
    public function handle(int $itemsPerPage, string $search): AbstractPaginator;
}
