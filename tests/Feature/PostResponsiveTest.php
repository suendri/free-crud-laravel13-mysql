<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('posts page renders mobile cards and reusable alpine confirm dialog', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create([
        'name' => 'Tutorial',
    ]);
    $post = Post::factory()->create([
        'category_id' => $category->id,
        'title' => 'Mobile Post',
        'text' => 'Konten untuk mobile view.',
    ]);

    $this->actingAs($user)
        ->get(route('posts.index'))
        ->assertSuccessful()
        ->assertSee('md:hidden', false)
        ->assertSee('hidden overflow-x-auto md:block', false)
        ->assertSee('x-data="{ open: false }"', false)
        ->assertSee('x-teleport="body"', false)
        ->assertSee('x-on:click="$wire.delete('.$post->id.'); open = false"', false)
        ->assertSee('Mobile Post')
        ->assertSee('Tutorial');
});
