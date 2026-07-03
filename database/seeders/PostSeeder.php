<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::query()->firstOrCreate(['name' => 'Laravel']);

        Post::query()->firstOrCreate(
            ['title' => 'Belajar CRUD Laravel'],
            [
                'category_id' => $category->id,
                'text' => 'Contoh post awal untuk latihan CRUD Laravel dengan Livewire.',
            ],
        );
    }
}
