<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            "user_id" => $this->user_id,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "title" => $this->title,
            "slug" => $this->slug,
            'thumbnail' => $this->thumbnail ? config('app.url') . '/storage/anime_thumbnails/' . md5($this->id) . '/' . $this->thumbnail->name : null,
        ];
    }
}
