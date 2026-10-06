<?php
declare(strict_types=1);

namespace App\Models;

use App\Infrastructure\Persistence\QueryBuilder\CourseProgressQuery;
use App\Infrastructure\Persistence\QueryBuilder\TeachingQuery;
use App\Models\LMS\Result;
use Illuminate\Database\Eloquent\Collection;

trait LegacyUserApi
{
    /** @deprecated $user->full_name */
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /** @deprecated $user->customer_label */
    public function getCustomer(): string
    {
        return $this->customer_label;
    }

    /** @deprecated $user->phone_digits */
    public function formatPhoneNumber(): string
    {
        return $this->phone_digits;
    }

    /** @deprecated $user->setDealer(true) */
    public function isDealer(): void
    {
        $this->setDealer(true);
    }

    /** @deprecated $user->setDealer(false) */
    public function isNotDealer(): void
    {
        $this->setDealer(false);
    }

    /** @deprecated $user->setDealer($value !== null) */
    public function switchDealer($value): void
    {
        $this->setDealer($value !== null);
    }

    /** @deprecated $user->latestOrder (связь, поддерживает with()) */
    public function getLastOrder(): ?Order
    {
        return $this->latestOrder;
    }

    /** @deprecated $user->results()->where('course_id', ...) */
    public function getResultsByCourse($course): Collection
    {
        return Result::query()
            ->where('user_id', $this->id)
            ->where('course_id', $course->id)
            ->get();
    }

    /** @deprecated CourseProgressQuery::points() */
    public function getPoints($course): int
    {
        return app(CourseProgressQuery::class)->points($this->id, $course->id);
    }

    /** @deprecated CourseProgressQuery::rank() */
    public function getRatingByCourse($course): int|false
    {
        return app(CourseProgressQuery::class)->rank($this->id, $course) ?? false;
    }

    /** @deprecated TeachingQuery::students() */
    public function getMyStudents()
    {
        return app(TeachingQuery::class)->students($this->id)->get();
    }

    /** @deprecated TeachingQuery::teachers() */
    public function getMyTeachers()
    {
        return app(TeachingQuery::class)->teachers($this->id)->get();
    }

    /** @deprecated TeachingQuery::students()/studentIds() */
    public function ownStudents(): array
    {
        return User::query()->whereIn('id', app(TeachingQuery::class)->studentIds($this->id))->get()->all();
    }

    /** @deprecated TeachingQuery::uncheckedHomeWorks() */
    public function uncheckedHomeWorks()
    {
        return app(TeachingQuery::class)->uncheckedHomeWorks($this->id)->get();
    }

    /** @deprecated TeachingQuery::homeWorks() */
    public function allHomeWorks()
    {
        return app(TeachingQuery::class)->homeWorks($this->id)->get();
    }

    /** @deprecated $user->chatsByLastMessage() */
    public function chatsByDesc(): array
    {
        return $this->chatsByLastMessage()->get()->all();
    }
}
