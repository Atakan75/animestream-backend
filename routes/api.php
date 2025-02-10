<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AnimeEpisodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;

use App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['prefix' => 'anime'], function () {
    Route::get('/', [AnimeController::class, 'index']);
    Route::get('/{anime_slug}', [AnimeController::class, 'show']);

    Route::get('/{anime_slug}/episode/{episode_slug}', [AnimeEpisodeController::class, 'show']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', function (Request $request) {
            return new UserResource($request->user());
        });
        Route::post('/avatar', [UserController::class, 'setUserAvatar']);
    });

    Route::group(['prefix' => 'video'], function () {
        Route::post('/upload', [VideoController::class, 'upload']);
    });
});

Route::post('/callback', [VideoController::class, 'callback']);

Route::post('/stripe/webhook', function (Request $request) {

    // Yönlendirmek istediğin hedef URL
    $targetUrl = "https://app.shiphack.co/api/stripe/webhook";

    // Mevcut isteğin methodunu al
    $method = $request->method();

    // Mevcut header'ları al
    $headers = $request->headers->all();

    // Header formatını düzelt
    $formattedHeaders = collect($headers)->mapWithKeys(function ($value, $key) {
        return [$key => $value[0]]; // Laravel her header'ı dizi olarak döndürüyor, ilk elemanı alıyoruz
    })->toArray();

    // Gövdeyi al
    $body = $request->getContent();

    // HTTP isteğini yönlendir
    $response = Http::withHeaders($formattedHeaders)
        ->withBody($body, $request->header('Content-Type') ?? 'application/json')
        ->send($method, $targetUrl, [
            'query' => $request->query(), // Query parametreleri de ekle
        ]);

    // Gelen yanıtı döndür
    return response($response->body(), $response->status())
        ->withHeaders($response->headers());
});
