<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\AnimeSeasonResource;
use App\Http\Resources\CommentResource;

class AnimeEpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ? $this->id : null,
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail ? config('app.url') . '/storage/anime_thumbnails/' . md5($this->id) . '/' . $this->thumbnail->name : null,
            'summary' => $this->summary ? $this->summary : null,
            'duration' => $this->duration ? $this->duration : null,
            'season' => new AnimeSeasonResource($this->whenLoaded('season')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => $this->created_at ? $this->created_at : null,
        ];
    }
}
