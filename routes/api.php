<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AnimeEpisodeController;

use App\Http\Resources\UserResource;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix'=> 'profile'], function () {
    Route::get('/{username}', [UserProfileController::class, 'show']);
});

Route::group(['prefix' => 'anime'], function () {
    Route::get('/', [AnimeController::class, 'index']);
    Route::get('/{anime_slug}', [AnimeController::class, 'show']);

    Route::get('/{anime_slug}/episode/{episode_slug}', [AnimeEpisodeController::class, 'show']);

    
    Route::post('/thumbnail/{id}', [AnimeController::class, 'setAnimeThumbnail']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', function (Request $request) {
            return new UserResource($request->user()->load("roles"));
        });
        Route::post('/avatar', [UserController::class, 'setUserAvatar']);
    });

    Route::group(['prefix' => 'video'], function () {
        Route::post('/upload', [VideoController::class, 'upload']);
    });
});

Route::post('/callback', [VideoController::class, 'callback']);

Route::post('/stripe/webhook', [UserController::class, 'stripeWebhook']);
