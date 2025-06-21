<?php
namespace App\Http\Controllers;

use App\Http\Requests\AnimeIndexRequest;
use App\Http\Resources\AnimeResource;
use App\Models\Anime;
use App\Http\Requests\AnimeThumbnailRequest;
use App\Services\FileService;


class AnimeController extends Controller
{
    public function index(AnimeIndexRequest $request)
    {
        $animes = Anime::with([
            'genres' => function ($query) {
                $query->select('name');
            },
            'seasons' => function ($query) {
                $query->with('episodes');
            },
            'thumbnail'
        ])->withCount('seasons');

        if ($request->has('search')) {
            $animes->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('genre')) {
            $animes->whereHas('genres', function ($query) use ($request) {
                $genres = explode(',', $request->genre);
                $query->whereIn('id', $genres);
            });
        }

        if ($request->has('sort')) {
            $animes->orderBy($request->sort, 'asc');
        }

        $limit  = empty($request->perPage) ? 15 : intval($request->perPage);
        $offset = empty($request->page) ? 0 : (intval($request->page) - 1) * $limit;

        $animes = $animes->limit($limit)->offset($offset)->get();

        return response_success([
            'message' => 'Animes retrieved successfully',
            'animes'  => AnimeResource::collection($animes),
        ], 200);
    }

    public function show($slug)
    {
        $anime = Anime::where('slug', $slug)->with([
            'genres'   => function ($query) {
                $query->select('name');
            },
            'seasons'  => function ($query) {
                $query->with(['episodes']);
            },
            'comments' => function ($query) {
                $query->with([
                    'parent.parent.parent.parent.parent',
                    'user'
                ])->whereNull('parent_id');
            },
        ])->first();

        return response_success([
            'message' => 'Anime retrieved successfully',
            'anime'   => $anime,
        ], 200);
    }

    public function setAnimeThumbnail($id, AnimeThumbnailRequest $request, FileService $fileService)
    {
        $anime = Anime::find($id);
        $anime->thumbnail()->delete();

        $fileData = $fileService->uploadAnimeThumbnail(
            $request->file('anime_thumbnail'),
            $anime->id
        );

        $thumbnail = $anime->thumbnail()->create($fileData);

        return response_success([
            'message' => 'Thumbnail başarıyla yüklendi',
            'thumbnail'  => $thumbnail,
        ], 200);
    }
}
    