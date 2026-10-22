<?php
declare(strict_types=1);

namespace Tests\Support;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class Roles
{
    public const string ADMIN_ROLE = 'admin';
    public const string STUDENT_ROLE = 'student';

    /**
     * Если админка защищена через permission:..., перечислите нужные права.
     * @var list<string>
     */
    public const array ADMIN_PERMISSIONS = [];

    public static function admin(): User
    {
        $user = User::factory()->create();
        $user->assignRole(
            self::role(
                self::ADMIN_ROLE,
                self::ADMIN_PERMISSIONS
            )
        );

        return $user;
    }

    public static function student(): User
    {
        $user = User::factory()->create();
        $user->assignRole(self::role(self::STUDENT_ROLE));

        return $user;
    }

    /** @param list<string> $permissions */
    private static function role(string $name, array $permissions = []): Role
    {
        $guard = config('auth.defaults.guard', 'web');

        $role = Role::findOrCreate($name, $guard);

        foreach ($permissions as $permission) {
            $role->givePermissionTo(Permission::findOrCreate($permission, $guard));
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return $role;
    }
}