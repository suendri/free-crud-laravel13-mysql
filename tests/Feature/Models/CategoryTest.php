<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a category has a name', function () {
    $category = Category::factory()->make([
        'name' => 'Laravel',
    ]);

    expect($category->name)->toBe('Laravel');
});
