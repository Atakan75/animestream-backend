<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Models\AnimeEpisode;

use App\Http\Resources\AnimeEpisodeResource;
use App\Models\UserWatchHistory;

class AnimeEpisodeController extends Controller
{
    public function show($anime_slug, $episode)
    {
        $animeEpisode = cache()->remember("anime_episode_{$episode}", 60 * 60 * 24, function () use ($episode) {
            return AnimeEpisode::with([
                'season' => function ($query) {
                    $query->with([
                        'episodes' => function ($query) {
                            $query->select('id', 'slug', 'name', 'season_id')
                                ->orderBy('created_at', 'desc');
                        },
                    ]);
                },
                'comments' => function ($query) {
                    $query->with([
                        'parent.parent.parent.parent.parent',
                        'user' => function ($query) {
                            $query->select('id', 'name');
                        },
                    ])->whereNull('parent_id')
                        ->orderBy('created_at', 'desc');
                },
            ])->where('slug', $episode)->first();
        });

        return response_success([
            'episode' => ($animeEpisode),
        ]);
    }
}
