<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'inventario'
], function ($router) {
    Route::post('search', [InventarioController::class, 'searchProductOrLocation']);
    Route::post('register', [InventarioController::class, 'register']);
    Route::post('update', [InventarioController::class, 'update']);
    Route::post('delete', [InventarioController::class, 'delete']);
});
