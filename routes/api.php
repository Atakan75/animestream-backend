<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AnimeEpisodeController;
use App\Http\Controllers\AnimeCommentController;
use App\Http\Controllers\AnimeEpisodeCommentController;

use App\Http\Resources\UserResource;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix'=> 'profile'], function () {
    Route::get('/{username}', [UserProfileController::class, 'show']);
});

Route::group(['prefix' => 'widget'], function () {
    Route::get('/new-released-animes', [WidgetController::class, 'getNewReleasedAnimes']);
});

Route::group(['prefix' => 'anime'], function () {
    Route::get('/', [AnimeController::class, 'index']);

    Route::get('/{anime_slug}', [AnimeController::class, 'show']);

    Route::get('/{anime_slug}/episode/{episode_slug}', [AnimeEpisodeController::class, 'show']);
});

Route::group(['prefix'=> 'blog'], function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/{slug}', [BlogController::class, 'show']);

    //████████  ██████  ██████   ██████  
    //   ██    ██    ██ ██   ██ ██    ██ 
    //   ██    ██    ██ ██   ██ ██    ██ 
    //   ██    ██    ██ ██   ██ ██    ██ 
    //   ██     ██████  ██████   ██████  
        /**TODO
        * ! middleware e taşınacak. 
        */
    Route::post('/{id}', action: [BlogController::class, 'setBlogThumbnail']);

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
    Route::group(['prefix'=> 'blog'], function () {
        Route::post('/', [BlogController::class, 'store']);
    });

    Route::group(['prefix' => 'anime'], function () {
        Route::post('/thumbnail/{id}', action: [AnimeController::class, 'setAnimeThumbnail']);
    
        Route::group(['prefix' => 'episode'], function () {
            Route::group(['prefix' => 'comment'], function () {
                Route::post('/', [AnimeEpisodeCommentController::class, 'store']);
                Route::delete('/{id}', [AnimeEpisodeCommentController::class, 'destroy']);
            });
            Route::post('/thumbnail/{id}', action: [AnimeEpisodeController::class, 'setEpisodeThumbnail']);
        });

        Route::group(['prefix' => 'comment'], function () {
            Route::post('/', [AnimeCommentController::class, 'store']);
            Route::delete('/{id}', [AnimeCommentController::class, 'destroy']);
        });
    });
});

Route::post('/callback', [VideoController::class, 'callback']);

Route::post('/stripe/webhook', [UserController::class, 'stripeWebhook']);
