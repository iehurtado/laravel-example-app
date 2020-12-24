<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostsController;

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

Route::get('/posts/create', [PostsController::class, 'create'])->name('posts.create');
Route::post('/posts/{id}/delete', [PostsController::class, 'delete'])->name('posts.delete');
Route::get('/posts/{id}/update', [PostsController::class, 'update'])->name('posts.update');
Route::get('/posts/{id}', [PostsController::class, 'view'])->name('posts.view');
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
Route::put('/posts/{id}', [PostsController::class, 'edit'])->name('posts.edit');
