<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\Category\categoryController;
use App\Http\Controllers\Post\postController;
use App\Http\Controllers\Comment\commentController;
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

Route::get('/', function () {
    return view('welcome');
});
 
Route::controller(RegisterController::class)->group(function () {
    Route::get('register','showRegistrationForm')->name('register');
    Route::post('register','register')->name('regist.save');
});
Route::controller(loginController::class)->group(function () {
    Route::get('/login','showLoginForm')->name('login');
    Route::post('/login','login')->name('login');
});
Route::middleware(['checkSessionExpiration'])->group(function () {
    Route::controller(indexController::class)->group(function () {
        Route::get('/index','showDashBoard')->name('index');
        Route::get('/logout', 'logout')->name('logout');
    });
});

// Route::post('/posts', [PostController::class, 'store'])->middleware('save.created.by');

Route::post('/comment/insert', [commentController::class, 'insert'])->name('comment.insert');

Route::middleware(['checkSessionExpiration'])->group(function () {
Route::controller(postController::class)->group(function () {
    Route::get('/post/{categoryId}','index')->name('posts.index');
    Route::get('/post/create', 'create');
    Route::post('/post/{categoryId}', 'insert')->name('post.insert');//->middleware('save.created.by');
    });
});
Route::middleware(['admin','checkSessionExpiration'])->group(function () {
    Route::controller(categoryController::class)->group(function () {
        Route::get('/category/index', 'index')->name('category.index');
        Route::get('/category/create', 'create');
        Route::post('/category/insert', 'insert')->name('category.insert');
        Route::get('/category/{id}', 'edit')->name('category.edit');
        Route::put('/category/update/{id}','update')->name('category.update');
        Route::delete('/category/delete/{id}', 'delete')->name('category.delete');
    });
});
