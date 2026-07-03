<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a post belongs to a category', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'category_id' => $category->id,
    ]);

    expect($post->category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($category->id);
});
