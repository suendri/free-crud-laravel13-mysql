<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard uses mobile first responsive markup', function () {
    $user = User::factory()->admin()->create([
        'role' => 'admin',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('sm:grid-cols-2', false)
        ->assertSee('xl:grid-cols-3', false)
        ->assertSee('lg:grid-cols-[minmax(0,1fr)_20rem]', false)
        ->assertSee('Akses Cepat')
        ->assertSee('admin');
});

test('app layout uses alpine mobile navigation controls', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('x-data="{ mobileMenuOpen: false }"', false)
        ->assertSee('x-show="mobileMenuOpen"', false)
        ->assertSee('aria-label="Buka navigasi"', false)
        ->assertSee('px-4 py-5 sm:px-6 sm:py-6 lg:px-8', false)
        ->assertDontSee('max-w-7xl', false);
});
