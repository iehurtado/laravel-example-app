<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// TODO ESTO:
// 
//Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
//Route::get('/posts/{post}', [PostsController::class, 'show'])->name('posts.show');
//Route::delete('/posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');
//Route::get('/posts/{post}/edit', [PostsController::class, 'edit'])->name('posts.edit');
//Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
//Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
//Route::put('/posts/{post}', [PostsController::class, 'update'])->name('posts.update');

// EQUIVALE A ESTO:
Route::resource('posts', PostsController::class); // ;-)

Route::resource('posts.comments', CommentsController::class)
    ->shallow()
    ->except(['index', 'create']);
