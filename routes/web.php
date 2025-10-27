<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function() {
    return app(ProfileController::class)->view(request(), request()->user()->id);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('user.posts');
Route::get('/posts/{id}', [PostController::class, 'view'])->name('posts.view');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/post/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/post/{id}/like', [PostController::class, 'like'])->name('posts.like');
});

require __DIR__.'/auth.php';
