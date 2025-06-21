<?php
namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Resources\AnimeEpisodeResource;
use App\Models\AnimeEpisode;
use App\Services\FileService;
use App\Http\Requests\AnimeEpisodeThumbnailRequest;

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
                        $query->select('id', 'name')
                            ->with([
                                'avatar'
                            ]);
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

    public function setEpisodeThumbnail($id, AnimeEpisodeThumbnailRequest $request, FileService $fileService)
    {
        $episode = AnimeEpisode::find($id);

        if (!$episode) {
            return response_error('Episode not found', 404);
        }

        $episode->thumbnail()->delete();

        $fileData = $fileService->uploadAnimeEpisodeThumbnail(
            $request->file('thumbnail'),
            $episode->id
        );

        $thumbnail = $episode->thumbnail()->create($fileData);

        return response_success([
            'message' => 'Thumbnail uploaded successfully',
            'thumbnail' => $thumbnail
        ], 200);
    }
}
