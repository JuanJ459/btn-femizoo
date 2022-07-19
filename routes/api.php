<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [App\Http\Controllers\AutenticacionControlador::class, 'register']);
Route::post('login', [App\Http\Controllers\AutenticacionControlador::class, 'login']); 

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('validate', [App\Http\Controllers\AutenticacionControlador::class, 'validateToken']);
    Route::post('logout', [App\Http\Controllers\AutenticacionControlador::class, 'logout']);
    
    Route::get('misDispositivos', [App\Http\Controllers\dispositivosControlador::class, 'index']);
    Route::get('reportar/dispositivo/{serie}', [App\Http\Controllers\dispositivosControlador::class, 'perdido']);
    Route::post('update/dispositivo', [App\Http\Controllers\dispositivosControlador::class, 'actualizar']);
    //Route::get('ver/dispositivo/{id}', [App\Http\Controllers\dispositivosControlador::class, 'show']);
    Route::post('actualizar/ubicacion/dispositivo', [App\Http\Controllers\dispositivosControlador::class, 'update']);
    Route::post('eliminar/dispositvo', [App\Http\Controllers\dispositivosControlador::class, 'destroy']);

    Route::get('productos', [App\Http\Controllers\productoControlador::class, 'index']);
    Route::get('crear/producto', [App\Http\Controllers\productoControlador::class, 'store']);
    Route::get('elimar/producto/{id}', [App\Http\Controllers\productoControlador::class, 'destroy']);
});
