<?php
declare(strict_types=1);

use App\Models\LMS\Category;
use App\Models\LMS\Course;
use App\Models\LMS\Language;

beforeEach(function (): void {
    Language::firstOrCreate(
        ['label' => 'cn'],
        ['name' => 'Chinese']
    );
});

it('creates a course through the react api', function (): void {
    $teacher = userWithRole('teacher');
    $category = Category::create([
        'name' => 'category',
        'label' => 'category'
    ]);

    $this->actingAs($teacher)
        ->postJson('/react/api/courses', [
            'title' => 'Новый курс',
            'difficultyLevel' => 'beginner',
            'paidType' => 'free',
            'categoryId' => $category->id,
        ])
        ->assertSuccessful();

    $course = Course::firstWhere('title', 'Новый курс');

    expect($course)->not->toBeNull()
        ->and($course->author_id)->toBe($teacher->id)
        ->and($course->category_id)->toBe($category->id)
        ->and((bool)$course->is_allowed)->toBeFalse();
});

it('does not allow creating a course on behalf of another author', function (): void {
    $teacher = userWithRole('teacher');
    $other = userWithRole('teacher');
    $category = Category::create([
        'name' => 'category',
        'label' => 'category'
    ]);

    $this->actingAs($teacher)
        ->postJson('/react/api/courses', [
            'title' => 'Чужой',
            'author_id' => $other->id,
            'difficultyLevel' => 'beginner',
            'paidType' => 'free',
            'categoryId' => $category->id,
        ]);

    expect(Course::firstWhere('title', 'Чужой')?->author_id)->toBe($teacher->id);
});

it('auto-approves courses of admins only', function (): void {
    Language::firstOrCreate(['label' => 'cn'], ['name' => 'Chinese']);
    $category = Category::create([
        'name' => 'category',
        'label' => 'category'
    ]);

    $this->actingAs(userWithRole('teacher'))
        ->postJson('/react/api/courses', [
            'title' => 'Учитель',
            'difficultyLevel' => 'beginner',
            'paidType' => 'free',
            'categoryId' => $category->id,
        ])->assertSuccessful();

    $this->actingAs(userWithRole('admin'))
        ->postJson('/react/api/courses', [
            'title' => 'Админ',
            'difficultyLevel' => 'beginner',
            'paidType' => 'free',
            'categoryId' => $category->id,
        ])->assertSuccessful();

    expect((bool)Course::firstWhere('title', 'Учитель')->is_allowed)->toBeFalse()
        ->and((bool)Course::firstWhere('title', 'Админ')->is_allowed)->toBeTrue();
});
