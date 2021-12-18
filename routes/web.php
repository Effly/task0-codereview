<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/links',[ShortLinkController::class,'store'])->name('generate.link');
Route::patch('/links/{id}',[ShortLinkController::class,'update'])->name('update.link');
Route::delete('/links/{id}',[ShortLinkController::class,'delete'])->name('delete.link');
Route::get('/links/{id}',[ShortLinkController::class,'getById'])->name('getById.link');
Route::get('/links',[ShortLinkController::class,'index'])->name('getAll.link');

Route::get('{code}',[ShortLinkController::class, 'followShortLink'])->name('followShortLink');

//Route::get('/stats{id}')

