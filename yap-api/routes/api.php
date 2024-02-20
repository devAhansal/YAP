<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PartenaireController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/animal', AnimalController::class);
});
Route::get('/animal', [AnimalController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/partenaires', PartenaireController::class);
});
Route::get('/partenaires', [PartenaireController::class, 'index']);