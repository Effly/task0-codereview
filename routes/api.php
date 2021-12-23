<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/links',[ShortLinkController::class,'store'])->name('generate.link');
Route::patch('/links/{id}',[ShortLinkController::class,'update'])->name('update.link');
Route::delete('/links/{id}',[ShortLinkController::class,'delete'])->name('delete.link');
Route::get('/links/{id}',[ShortLinkController::class,'getById'])->name('getById.link');
Route::get('/links',[ShortLinkController::class,'index'])->name('getAll.link');


Route::get('/stats/{code}',[StatsController::class,'getStatsByCode'])->name('getStatsByCode');
Route::get('/stats',[StatsController::class,'getStats'])->name('getStats');





