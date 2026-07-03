<?php

use App\Livewire\Posts\PostIndex;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('guests cannot view posts', function () {
    $this->get(route('posts.index'))
        ->assertRedirect(route('login'));
});

test('authenticated users can view posts', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSuccessful()
        ->assertSee('Posts');
});

test('authenticated users can create update and delete posts', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Tutorial',
    ]);

    Livewire::actingAs($user)
        ->test(PostIndex::class)
        ->set('categoryId', $category->id)
        ->set('title', 'Belajar Laravel')
        ->set('text', 'Konten latihan.')
        ->call('save')
        ->assertHasNoErrors();

    $post = Post::query()->where('title', 'Belajar Laravel')->firstOrFail();

    Livewire::actingAs($user)
        ->test(PostIndex::class)
        ->call('edit', $post->id)
        ->assertSet('categoryId', $category->id)
        ->assertSet('title', 'Belajar Laravel')
        ->set('title', 'Belajar Livewire')
        ->set('text', 'Konten diperbarui.')
        ->call('save')
        ->assertHasNoErrors();

    expect($post->refresh())
        ->title->toBe('Belajar Livewire')
        ->text->toBe('Konten diperbarui.');

    Livewire::actingAs($user)
        ->test(PostIndex::class)
        ->call('delete', $post->id);

    expect(Post::query()->whereKey($post->id)->exists())->toBeFalse();
});
