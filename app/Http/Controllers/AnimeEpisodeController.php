<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Models\AnimeEpisode;

class AnimeEpisodeController extends Controller
{
    public function index($slug)
    {
        $episode = AnimeEpisode::with([
            'season' => function ($query) {
                $query->with([
                    'episodes' => function ($query) {
                        $query->select('id', 'slug', 'name')
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
        ])->where('slug', $slug)->first();

        return response_success([
            'episode' => $episode,
        ]);
    }
}
