<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UserController;
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

Route::apiResource('contatos', ContatoController::class);
Route::apiResource('grupos', GrupoController::class);
Route::apiResource('users', UserController::class);

Route::post('login', [AuthController::class, 'login']);
Route::post('perfil', [AuthController::class, 'me']);
Route::post('logout', [AuthController::class, 'logout']);

