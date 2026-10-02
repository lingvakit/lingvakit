<?php
declare(strict_types=1);

namespace App\Application\User\Actions;

use App\Application\User\Dto\RegisterUserDto;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\WelcomeSetPasswordEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

final readonly class RegisterUser
{
    private const string STUDENT_ROLE = 'user';

    public function __invoke(RegisterUserDto $data): User
    {
        $user = DB::transaction(function () use ($data): User {
            $role = Role::findByName(self::STUDENT_ROLE);

            $user = User::withTrashed()
                ->where('email', $data->email)
                ->lockForUpdate()
                ->first();

            if ($user !== null && ! $user->trashed()) {
                throw ValidationException::withMessages([
                    'email' => 'Пользователь с таким email уже зарегистрирован.',
                ]);
            }

            $user?->restore();
            $user ??= new User()->forceFill(['email' => $data->email]);

            $user->forceFill([
                'name' => $data->name,
                'password' => Hash::make(Str::random(64)),
                'email_verified_at' => null,
            ])->save();

            $user->syncRoles([$role]);

            Setting::firstOrCreate(
                ['user_id' => $user->id],
                ['locale' => 'ru']
            );

            return $user;
        });

        $user->notify(new WelcomeSetPasswordEmail());

        return $user;
    }
}
