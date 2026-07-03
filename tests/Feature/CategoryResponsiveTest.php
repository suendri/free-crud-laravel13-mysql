<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('categories page renders mobile cards and reusable alpine confirm dialog', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Mobile Category',
    ]);

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertSuccessful()
        ->assertSee('md:hidden', false)
        ->assertSee('hidden overflow-x-auto md:block', false)
        ->assertSee('x-data="{ open: false }"', false)
        ->assertSee('x-teleport="body"', false)
        ->assertSee('aria-hidden="true"', false)
        ->assertDontSee('aria-label="Tutup dialog"', false)
        ->assertSee('x-on:click="$wire.delete('.$category->id.'); open = false"', false)
        ->assertSee('Mobile Category');
});
