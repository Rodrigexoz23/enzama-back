<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ViajeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\ReservaController;

// LOGIN (pública)
Route::post('/login', [AuthController::class, 'login']);

// RUTAS PROTEGIDAS
Route::middleware('auth:sanctum')->group(function () {

    // CLIENTAS
    Route::get('/clientas', [ClienteController::class, 'listarClientes']);
    Route::post('/clientas', [ClienteController::class, 'guardarCliente']);
    Route::delete('/clientas/{id}', [ClienteController::class, 'eliminarCliente']);

    // VIAJES
    Route::get('/viajes', [ViajeController::class, 'listarViajes']);
    Route::post('/viajes', [ViajeController::class, 'guardarViaje']);
    Route::delete('/viajes/{id}', [ViajeController::class, 'eliminarViaje']);

    // LOGOUT
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    });

    // RESERVAS
    Route::post('/reservas', [ReservaController::class, 'store']);
    Route::get('/viajes/{id}/clientas', [ReservaController::class, 'clientasPorViaje']);
    Route::get('/clientas/{id}/viajes', [ReservaController::class, 'viajesPorClienta']);

});
