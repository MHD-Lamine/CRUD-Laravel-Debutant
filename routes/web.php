<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::prefix('/blog')->controller(BlogController::class)->name('blog.')->group(function () {
    Route::get('/', 'index')->name('index')->middleware('auth');
    Route::get('/new','create')->name('create')->middleware('auth');
    Route::post('/ new','store')->middleware('auth');
    Route::get('/{post}/edit','edit')->name('edit')->middleware('auth');
    Route::patch('/{post}/edit', 'update')->middleware('auth');
    Route::get('/{slug}-{id}','show')->where([
        'slug'=> '[a-z0-9A-Z\ -]+$',
        'id'=>'[0-9]+',
    ])->name('show')->middleware('auth');
});
