<?php
declare(strict_types=1);

use App\Kafka\Producer\BaseProducer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(function (): void {
        $this->withoutVite();
        Http::preventStrayRequests();
        $this->mock(BaseProducer::class)->shouldIgnoreMissing();
    })
    ->in('Feature');

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Unit/Models', 'Unit/Query');

function userWithRole(string $role, array $attributes = []): User
{
    app(PermissionRegistrar::class)->forgetCachedPermissions();
    Role::findOrCreate($role, 'web');

    return User::factory()->create($attributes)->assignRole($role);
}