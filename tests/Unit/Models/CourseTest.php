<?php
declare(strict_types=1);

use App\Models\LMS\Course;
use App\Models\User;

it('formats a paid course without a sale price', function (): void {
    $course = new Course([
        'type' => 'paid',
        'price' => 1500,
        'sale_price' => null
    ]);

    expect($course->getPrice())->toBe('1 500 ₽')
        ->and($course->getDiscount())->toBe(0.0)
        ->and($course->getTotalPrice())->toBe(1500.0);
});

it('shows both prices when there is a discount', function (): void {
    $course = new Course([
        'type' => 'paid',
        'price' => 2000,
        'sale_price' => 1500
    ]);

    expect($course->getPrice())->toContain('2 000 ₽', '1 500 ₽')
        ->and($course->getDiscount())->toBe(500.0);
});

it('does not fail on a paid course with a null price', function (): void {
    expect(new Course([
        'type' => 'paid',
        'price' => null
    ])->getPrice())->toBe('0 ₽');
});

it('returns false for a missing video instead of a type error', function (): void {
    expect(new Course([
        'video' => null
    ])->getVideo())->toBeFalse();
});

it('does not divide by zero when a course has no topics', function (): void {
    $course = Course::factory()->create();

    expect(fn() => $course->updateProgress(
        User::factory()->create())
    )->not->toThrow(Throwable::class);
});
