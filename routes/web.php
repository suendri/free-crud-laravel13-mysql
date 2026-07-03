<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard.index', [
        'totalCategories' => Category::count(),
        'totalPosts' => Post::count(),
        'totalUsers' => User::count(),
    ]);
})
    ->middleware('auth')
    ->name('dashboard');

Route::get('/categories', function () {
    return view('categories.index');
})
    ->middleware('auth')
    ->name('categories.index');

Route::get('/posts', function () {
    return view('posts.index');
})
    ->middleware('auth')
    ->name('posts.index');

Route::get('/users', function () {
    return view('users.index');
})
    ->middleware(['auth', 'can:manage-users'])
    ->name('users.index');
