<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PartenaireController;
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
    Route::apiResource('/partenaires', PartenaireController::class);
    Route::apiResource('/commandes', CommandeController::class);
    Route::apiResource('/paniers', PanierController::class);
    Route::delete('/paniers/{commandeId}/{animalId}', [PanierController::class, 'destroy']);
    Route::post('/updateToPaye', [CommandeController::class, 'updateToPaye'])->name('updateToPaye');
    Route::get('/check-commandes-status',[CommandeController::class, 'checkcommandesstatus'])->name('checkcommandesstatus');
    Route::post('/create-payment',[PayPalController::class, 'createPayment'])->name('createPayment');
    Route::post('/success-payment',[PayPalController::class, 'success'])->name('createPayment');
});
Route::get('/animal', [AnimalController::class, 'index']);

