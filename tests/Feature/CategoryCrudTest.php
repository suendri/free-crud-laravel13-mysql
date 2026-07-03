<?php

use App\Livewire\Categories\CategoryIndex;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guests cannot view categories', function () {
    $this->get(route('categories.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users can view categories', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertSuccessful()
        ->assertSee('Categories');
});

test('authenticated users can create update and delete categories', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CategoryIndex::class)
        ->set('name', 'Programming')
        ->call('save')
        ->assertHasNoErrors();

    $category = Category::query()->where('name', 'Programming')->firstOrFail();

    Livewire::actingAs($user)
        ->test(CategoryIndex::class)
        ->call('edit', $category->id)
        ->assertSet('name', 'Programming')
        ->set('name', 'Laravel')
        ->call('save')
        ->assertHasNoErrors();

    expect($category->refresh()->name)->toBe('Laravel');

    Livewire::actingAs($user)
        ->test(CategoryIndex::class)
        ->call('delete', $category->id);

    expect(Category::query()->whereKey($category->id)->exists())->toBeFalse();
});
