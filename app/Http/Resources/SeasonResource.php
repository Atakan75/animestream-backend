<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\AnimeResource;
use App\Http\Resources\AnimeEpisodeResource;

class SeasonResource extends JsonResource
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
            "anime" => new AnimeResource($this->anime),
            "episodes" => AnimeEpisodeResource::collection($this->episodes),
            "name" => $this->name,
        ];
    }
}
