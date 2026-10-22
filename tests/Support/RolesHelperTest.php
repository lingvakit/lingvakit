<?php
declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\Support\Roles;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(fn () => app(PermissionRegistrar::class)->forgetCachedPermissions());

it('creates an admin with the admin role', function () {
    $admin = Roles::admin();

    expect($admin->hasRole(Roles::ADMIN_ROLE))->toBeTrue()
        ->and($admin->hasRole(Roles::STUDENT_ROLE))->toBeFalse();
});

it('creates a student without the admin role', function () {
    $student = Roles::student();

    expect($student->hasRole(Roles::STUDENT_ROLE))->toBeTrue()
        ->and($student->hasRole(Roles::ADMIN_ROLE))->toBeFalse();
});

it('can be called several times without duplicating roles', function () {
    Roles::admin();
    Roles::admin();

    expect(Role::where('name', Roles::ADMIN_ROLE)->count())->toBe(1);
});