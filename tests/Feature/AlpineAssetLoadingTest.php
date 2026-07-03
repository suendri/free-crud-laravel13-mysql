<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest auth pages load livewire script configuration for alpine', function () {
    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSee('window.livewireScriptConfig', false);
});

test('authenticated app pages load livewire script configuration for alpine', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSee('window.livewireScriptConfig', false);
});
