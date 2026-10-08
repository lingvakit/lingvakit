<?php

declare(strict_types=1);

use App\Models\LMS\Course;

it('rejects guests with 401 JSON', function (string $method, string $uri): void {
    $this->json($method, $uri)->assertUnauthorized();
})->with([
    ['GET', '/react/api/courses'],
    ['POST', '/react/api/courses'],
    ['POST', '/react/api/media/upload'],
    ['GET', '/react/api/categories'],
]);

it('rejects authenticated students with 403', function (): void {
    $this->actingAs(userWithRole('user'))
        ->getJson('/react/api/courses')
        ->assertForbidden();
});

it('allows teachers and admins to list courses', function (string $role): void {
    $this->actingAs(userWithRole($role))
        ->getJson('/react/api/courses')
        ->assertOk();
})->with(['teacher', 'admin']);

it('does not let a teacher update a foreign course', function (): void {
    $owner = userWithRole('teacher');
    $other = userWithRole('teacher');
    $course = Course::factory()->create(['author_id' => $owner->id]);

    $this->actingAs($other)
        ->putJson("/react/api/courses/{$course->id}", ['title' => 'Hacked'])
        ->assertForbidden();
});

it('has no unprotected react api routes', function (): void {
    $open = collect(app('router')->getRoutes()->getRoutes())
        ->filter(fn($r) => str_starts_with($r->uri(), 'react/api'))
        ->reject(fn($r) => in_array('auth', $r->gatherMiddleware(), true));

    expect($open)->toBeEmpty();
});

it('updates a course without category', function (): void {
    $teacher = userWithRole('teacher');
    $course = Course::factory()->create([
        'author_id' => $teacher->id,
        'category_id' => null
    ]);

    $this->actingAs($teacher)
        ->putJson("/react/api/courses/{$course->id}", ['title' => 'Без категории'])
        ->assertOk();
});
