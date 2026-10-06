<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('builds the full name skipping empty parts', function (): void {
    $user = new User(['surname' => 'Иванов', 'name' => 'Иван', 'patronymic' => null]);

    expect($user->full_name)->toBe('Иванов Иван');
});

it('keeps only digits of the phone', function (): void {
    expect((new User(['phone' => '+7 (999) 123-45-67']))->phone_digits)->toBe('79991234567')
        ->and((new User())->phone_digits)->toBe('');
});

it('hashes a plain password through the cast and does not double-hash', function (): void {
    $plain = User::factory()->create(['password' => 'Plain-pass-1']);
    $hashed = User::factory()->create(['password' => Hash::make('Other-pass-1')]);

    expect(Hash::isHashed($plain->password))->toBeTrue()
        ->and(Hash::check('Plain-pass-1', $plain->password))->toBeTrue()
        ->and(Hash::check('Other-pass-1', $hashed->password))->toBeTrue();
});

it('does not allow mass assignment of privileged fields', function (string $field): void {
    expect((new User())->isFillable($field))->toBeFalse();
})->with(['password', 'is_staff', 'is_dealer', 'is_active', 'company_id', 'role_id', 'email_verified_at']);

it('hides sensitive attributes from serialization', function (): void {
    $array = User::factory()->create(['passport' => '4500 123456'])->toArray();

    expect($array)->not->toHaveKeys(['password', 'remember_token', 'passport']);
});

it('toggles the dealer flag explicitly', function (): void {
    $user = User::factory()->create(['is_dealer' => false]);

    $user->setDealer(true);
    expect($user->fresh()->is_dealer)->toBeTrue();

    $user->setDealer(false);
    expect($user->fresh()->is_dealer)->toBeFalse();
});