<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('users page renders mobile cards and reusable alpine confirm dialog', function () {
    $admin = User::factory()->admin()->create([
        'name' => 'Admin Active',
    ]);
    $operator = User::factory()->create([
        'name' => 'Mobile Operator',
        'email' => 'mobile-operator@example.test',
        'role' => 'operator',
    ]);

    $this->actingAs($admin)
        ->get(route('users.index'))
        ->assertSuccessful()
        ->assertSee('md:hidden', false)
        ->assertSee('hidden overflow-x-auto md:block', false)
        ->assertSee('form-select-control', false)
        ->assertSee('x-data="{ open: false }"', false)
        ->assertSee('x-teleport="body"', false)
        ->assertSee('x-on:click="$wire.delete('.$operator->id.'); open = false"', false)
        ->assertSee('Mobile Operator')
        ->assertSee('mobile-operator@example.test')
        ->assertSee('Aktif');
});
