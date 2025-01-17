<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AnimeEpisodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;

use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix' => 'anime'], function () {
    Route::get('/', [AnimeController::class, 'index']);
    Route::get('/{anime_slug}', [AnimeController::class, 'show']);

    Route::get('/{anime_slug}/episode/{episode_slug}', [AnimeEpisodeController::class, 'show']);

});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/user/avatar', [UserController::class, 'setUserAvatar']);
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post('/upload-test', [VideoController::class, 'upload']);

});
