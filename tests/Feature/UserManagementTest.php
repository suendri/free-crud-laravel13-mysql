<?php

use App\Livewire\Users\UserIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guests cannot view users', function () {
    $this->get(route('users.index'))
        ->assertRedirect(route('login'));
});

test('operators cannot view users', function () {
    $operator = User::factory()->create([
        'role' => 'operator',
    ]);

    $this->actingAs($operator)
        ->get(route('users.index'))
        ->assertForbidden();
});

test('admins can view users', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertSuccessful()
        ->assertSee('Users &amp; Role', false);
});

test('admins can create update role and delete users', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->set('name', 'Operator User')
        ->set('email', 'operator@example.test')
        ->set('password', 'password123')
        ->set('role', 'operator')
        ->call('save')
        ->assertHasNoErrors();

    $user = User::query()->where('email', 'operator@example.test')->firstOrFail();

    expect($user)
        ->name->toBe('Operator User')
        ->role->toBe('operator')
        ->and(Hash::check('password123', $user->password))->toBeTrue();

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->call('updateRole', $user->id, 'admin');

    expect($user->refresh()->role)->toBe('admin');

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->call('edit', $user->id)
        ->assertSet('name', 'Operator User')
        ->set('name', 'Updated User')
        ->set('password', '')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->refresh())
        ->name->toBe('Updated User')
        ->role->toBe('admin')
        ->and(Hash::check('password123', $user->password))->toBeTrue();

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->call('delete', $user->id);

    expect(User::query()->whereKey($user->id)->exists())->toBeFalse();
});

test('admins cannot change their own role or delete themselves', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->call('updateRole', $admin->id, 'operator');

    expect($admin->refresh()->role)->toBe('admin');

    Livewire::actingAs($admin)
        ->test(UserIndex::class)
        ->call('delete', $admin->id);

    expect(User::query()->whereKey($admin->id)->exists())->toBeTrue();
});
