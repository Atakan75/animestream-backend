<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\SeasonResource;

class AnimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "release_date" => $this->release_date,
            "imdb_score" => $this->imdb_score,
            "summary" => $this->summary,
            "seasons_count" => $this->seasons_count,
            "genres" => $this->genres,
            "seasons" => SeasonResource::collection($this->whenLoaded("seasons")),
            "thumbnail" => $this->thumbnail ? config('app.url') . '/storage/anime_thumbnails/' . md5($this->id) . '/' . $this->thumbnail->name : null,
            "comments" => CommentResource::collection($this->whenLoaded("comments")),
        ];
    }
}
