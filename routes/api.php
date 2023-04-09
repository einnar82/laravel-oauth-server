<?php

use App\Http\Controllers\API\Passport\PasswordGrantController;
use App\Http\Controllers\API\Passport\PersonalAccessClientController;
use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/users', UsersController::class);
Route::post('/login', [PasswordGrantController::class, 'login']);
Route::put('/logout', [PasswordGrantController::class, 'logout'])
    ->middleware('auth:api');
Route::post('/personal-access-token/{user}/create', [PersonalAccessClientController::class, 'createToken']);
