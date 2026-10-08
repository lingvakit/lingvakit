<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\LMS\Course;
use App\Models\User;

final class CoursePolicy
{
    public function update(User $user, Course $course): bool
    {
        return $user->hasAnyRole(['admin', 'superuser']) || $course->author_id === $user->id;
    }
}