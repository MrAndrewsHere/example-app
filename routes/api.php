<?php

use App\Domain\Controllers\AdController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExampleController;
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
Route::get('/test',ExampleController::class);
Route::prefix('/v1')->group(function () {
    Route::get('/', fn() => app()->version());

    Route::get('/ads', [AdController::class, 'index'])->name('ads');
    Route::get('/ad', [AdController::class, 'get']);
    Route::post('/ad', [AdController::class, 'store']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
