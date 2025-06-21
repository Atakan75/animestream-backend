<?php
namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Resources\AnimeEpisodeResource;
use App\Models\AnimeEpisode;

class AnimeEpisodeController extends Controller
{
    public function show($anime_slug, $episode)
    {
        $animeEpisode = AnimeEpisode::with([
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
            'thumbnail'
        ])->where('slug', $episode)->first();

        return response_success([
            'episode' => new AnimeEpisodeResource($animeEpisode),
        ]);
    }
}
