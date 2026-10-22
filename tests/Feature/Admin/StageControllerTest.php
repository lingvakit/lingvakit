<?php
declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken as AppVerifyCsrfToken;
use App\Models\LMS\Course;
use App\Models\LMS\Stage;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;
use Tests\Support\Roles;

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    $this->withoutMiddleware([
        AppVerifyCsrfToken::class,
        VerifyCsrfToken::class,
        ValidateCsrfToken::class,
        PreventRequestForgery::class,
    ]);

    $this->course = Course::factory()->create();
    $this->admin = stageTestAdmin();
});

uses(RefreshDatabase::class);

function stageTestAdmin(): User
{
    return Roles::admin();
}

function stageTestStudent(): User
{
    return Roles::student();
}

dataset('invalid stage names', [
    'missing' => [[]],
    'null' => [['name' => null]],
    'empty string' => [['name' => '']],
    'whitespace only' => [['name' => '   ']],
    'array' => [['name' => ['x']]],
    'too long (256)' => [['name' => str_repeat('a', 256)]],
]);

describe('store', function () {
    it('creates a stage in the course and redirects back', function () {
        $this->actingAs($this->admin)
            ->from('/previous')
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: ['name' => 'Module 1']
            )
            ->assertRedirect('/previous');

        $this->assertDatabaseHas('lms_stages', [
            'name' => 'Module 1',
            'course_id' => $this->course->id,
        ]);
    });

    it('takes course_id from the route, ignoring the request body', function () {
        $other = Course::factory()->create();

        $this->actingAs($this->admin)
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: [
                    'name' => 'Module',
                    'course_id' => $other->id
                ])
            ->assertRedirect();

        $stage = Stage::query()->where('name', 'Module')->firstOrFail();

        expect($stage->course_id)->toBe($this->course->id);
        $this->assertDatabaseMissing(
            table: 'lms_stages',
            data: ['course_id' => $other->id]
        );
    });

    it('ignores non-fillable fields such as id', function () {
        $this->actingAs($this->admin)
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: [
                    'name' => 'Module',
                    'id' => 999_999
                ])
            ->assertRedirect();

        $this->assertDatabaseMissing(
            table: 'lms_stages',
            data: ['id' => 999_999]
        );
        $this->assertDatabaseCount(
            table: 'lms_stages',
            count: 1
        );
    });

    it('rejects invalid names and creates nothing', function (array $payload) {
        $this->actingAs($this->admin)
            ->from('/previous')
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: $payload
            )
            ->assertRedirect('/previous')
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('lms_stages', 0);
    })->with('invalid stage names');

    it('accepts names on the length boundary', function (string $name) {
        $this->actingAs($this->admin)
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: ['name' => $name])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            table: 'lms_stages',
            data: ['name' => $name]
        );
    })->with([
        '255 latin chars' => [str_repeat('a', 255)],
        '255 cyrillic chars' => [str_repeat('я', 255)],
        'single char' => ['A'],
    ]);

    it('returns 404 for a non-existent course', function () {
        $this->actingAs($this->admin)
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: 999_999),
                data: ['name' => 'Module']
            )
            ->assertNotFound();

        $this->assertDatabaseCount('lms_stages', 0);
    });

    it('does not let guests create stages', function () {
        $status = $this->post(
            uri: route(
                name: 'stages.store',
                parameters: $this->course),
            data: ['name' => 'Module'])
            ->status();

        expect($status)->toBeIn([302, 401, 403]);
        $this->assertDatabaseCount('lms_stages', 0);
    });

    it('does not let non-admin users create stages', function () {
        $status = $this->actingAs(stageTestStudent())
            ->post(
                uri: route(
                    name: 'stages.store',
                    parameters: $this->course
                ),
                data: ['name' => 'Module'])
            ->status();

        expect($status)->toBeIn([302, 401, 403]);
        $this->assertDatabaseCount('lms_stages', 0);
    });
});

describe('update', function () {
    beforeEach(function () {
        $this->stage = Stage::factory()->create([
            'course_id' => $this->course->id,
            'name' => 'Old'
        ]);
    });

    it('renames the stage and redirects back', function () {
        $this->actingAs($this->admin)
            ->from('/previous')
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage]
                ),
                ['name' => 'New']
            )
            ->assertRedirect('/previous');

        expect($this->stage->fresh()->name)->toBe('New');
    });

    it('does not allow moving a stage to another course via course_id (mass assignment regression)', function () {
        $other = Course::factory()->create();

        $this->actingAs($this->admin)
            ->put(
                uri: route(
                    'stages.update',
                    [$this->course, $this->stage]
                ),
                data: [
                    'name' => 'New',
                    'course_id' => $other->id,
                ])
            ->assertRedirect();

        expect($this->stage->fresh()->name)->toBe('New')
            ->and($this->stage->fresh()->course_id)->toBe($this->course->id);
    });

    it('ignores non-fillable fields such as id', function () {
        $this->actingAs($this->admin)
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage
                    ]),
                [
                    'name' => 'New',
                    'id' => 999_999
                ])
            ->assertRedirect();

        $this->assertDatabaseHas(
            'lms_stages',
            [
                'id' => $this->stage->id,
                'name' => 'New'
            ]);
        $this->assertDatabaseMissing('lms_stages', ['id' => 999_999]);
    });

    it('does not touch other stages of the same course', function () {
        $sibling = Stage::factory()->create(['course_id' => $this->course->id, 'name' => 'Sibling']);

        $this->actingAs($this->admin)
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage
                    ]),
                ['name' => 'New']
            )
            ->assertRedirect();

        expect($sibling->fresh()->name)->toBe('Sibling');
    });

    it('rejects invalid names and keeps the old one', function (array $payload) {
        $this->actingAs($this->admin)
            ->from('/previous')
            ->put(route('stages.update', [$this->course, $this->stage]), $payload)
            ->assertRedirect('/previous')
            ->assertSessionHasErrors('name');

        expect($this->stage->fresh()->name)->toBe('Old');
    })->with('invalid stage names');

    it('accepts a name of exactly 255 characters', function () {
        $name = str_repeat('я', 255);

        $this->actingAs($this->admin)
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage]
                ),
                ['name' => $name])
            ->assertSessionHasNoErrors();

        expect($this->stage->fresh()->name)->toBe($name);
    });

    it('returns 404 for a non-existent stage', function () {
        $this->actingAs($this->admin)
            ->put(route('stages.update', [$this->course, 999_999]), ['name' => 'New'])
            ->assertNotFound();
    });

    it('returns 404 for a soft-deleted stage', function () {
        $this->stage->delete();

        $this->actingAs($this->admin)
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage->id]
                ),
                ['name' => 'New']
            )
            ->assertNotFound();

        expect(Stage::withTrashed()->find($this->stage->id)->name)->toBe('Old');
    });

    it('returns 404 when the stage belongs to another course', function () {
        $foreign = Stage::factory()->create(
            [
                'course_id' => Course::factory()->create()->id,
                'name' => 'Foreign'
            ]);

        $this->actingAs($this->admin)
            ->put(
                route(
                    'stages.update',
                    [$this->course, $foreign]
                ),
                ['name' => 'Hacked']
            )
            ->assertNotFound();

        expect($foreign->fresh()->name)->toBe('Foreign');
    });

    it('does not let guests rename stages', function () {
        $status = $this->put(
            route(
                'stages.update',
                [$this->course, $this->stage]
            ),
            ['name' => 'New']
        )->status();

        expect($status)->toBeIn([302, 401, 403])
            ->and($this->stage->fresh()->name)->toBe('Old');
    });

    it('does not let non-admin users rename stages', function () {
        $status = $this->actingAs(stageTestStudent())
            ->put(
                route(
                    'stages.update',
                    [$this->course, $this->stage]
                ),
                ['name' => 'New']
            )
            ->status();

        expect($status)->toBeIn([302, 401, 403])
            ->and($this->stage->fresh()->name)->toBe('Old');
    });
});

describe('destroy', function () {
    beforeEach(function () {
        $this->stage = Stage::factory()->create(['course_id' => $this->course->id]);
    });

    it('soft-deletes the stage and redirects back', function () {
        $this->actingAs($this->admin)
            ->from('/previous')
            ->delete(
                route(
                    'stages.destroy',
                    [$this->course, $this->stage]
                )
            )
            ->assertRedirect('/previous');

        $this->assertSoftDeleted('lms_stages', ['id' => $this->stage->id]);
    });

    it('does not touch other stages of the course', function () {
        $sibling = Stage::factory()->create(['course_id' => $this->course->id]);

        $this->actingAs($this->admin)
            ->delete(
                route(
                    'stages.destroy',
                    [$this->course, $this->stage]
                )
            )
            ->assertRedirect();

        $this->assertNotSoftDeleted('lms_stages', ['id' => $sibling->id]);
    });

    it('returns 404 on repeated deletion', function () {
        $url = route('stages.destroy', [$this->course, $this->stage->id]);

        $this->actingAs($this->admin)->delete($url)->assertRedirect();
        $this->actingAs($this->admin)->delete($url)->assertNotFound();
    });

    it('returns 404 for a non-existent stage', function () {
        $this->actingAs($this->admin)
            ->delete(route('stages.destroy', [$this->course, 999_999]))
            ->assertNotFound();
    });

    // IDOR. Красный, пока в роутах не включён ->scoped().
    it('returns 404 when the stage belongs to another course', function () {
        $foreign = Stage::factory()->create(['course_id' => Course::factory()->create()->id]);

        $this->actingAs($this->admin)
            ->delete(route('stages.destroy', [$this->course, $foreign]))
            ->assertNotFound();

        $this->assertNotSoftDeleted('lms_stages', ['id' => $foreign->id]);
    });

    it('does not let guests delete stages', function () {
        $status = $this->delete(
            route(
                'stages.destroy',
                [$this->course, $this->stage]
            )
        )->status();

        expect($status)->toBeIn([302, 401, 403]);
        $this->assertNotSoftDeleted('lms_stages', ['id' => $this->stage->id]);
    });

    it('does not let non-admin users delete stages', function () {
        $status = $this->actingAs(stageTestStudent())
            ->delete(route('stages.destroy', [$this->course, $this->stage]))
            ->status();

        expect($status)->toBeIn([302, 401, 403]);
        $this->assertNotSoftDeleted('lms_stages', ['id' => $this->stage->id]);
    });
});