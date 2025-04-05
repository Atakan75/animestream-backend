<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Anime;
use App\Http\Resources\AnimeResource;

class WidgetController extends Controller
{
    public function getNewReleasedAnimes()
    {
        $animes = Cache::remember('new_released_animes', 60, function () {
            return Anime::orderBy('created_at', 'desc')
                ->with([
                    'seasons' => function ($query) {
                        $query->with([
                            'episodes' => function ($query) {
                                $query->select('id', 'title', 'number', 'duration', 'thumbnail', 'video');
                            }
                        ]);
                    }
                ])
                ->take(10)->get();
        });

        return AnimeResource::collection($animes);
    }
}
