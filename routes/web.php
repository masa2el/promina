<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ImagesController;

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

Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('albums', [AlbumsController::class, 'index'])->name('albums.index');
Route::post('albums/store', [AlbumsController::class, 'store'])->name('albums.store');
Route::post('albums/delete', [AlbumsController::class, 'delete'])->name('albums.delete');
Route::post('albums/update', [AlbumsController::class, 'update'])->name('albums.update');
Route::get('images/{album}', [ImagesController::class, 'index'])->name('images.index');
Route::post('images/store', [ImagesController::class, 'store'])->name('images.store');
Route::post('images/delete', [ImagesController::class, 'delete'])->name('images.delete');
Route::post('images/update', [ImagesController::class, 'update'])->name('images.update');