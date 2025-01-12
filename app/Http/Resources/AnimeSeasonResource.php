<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\AnimeEpisodeResource;

class AnimeSeasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'episodes' => AnimeEpisodeResource::collection($this->whenLoaded('episodes')),
            'created_at' => $this->created_at,
        ];
    }
}
