<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimeController;

use App\Http\Resources\UserResource;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/anime', [AnimeController::class, 'index']);
Route::get('/anime/{slug}', [AnimeController::class, 'show']);

Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/user/avatar', [UserController::class, 'setUserAvatar']);
});
