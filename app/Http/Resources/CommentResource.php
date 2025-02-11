<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id ?? null,
            'comment' => $this->resource->comment ?? null,
            'user' => $this->when($this->resource->user, new UserResource($this->resource->user)),
            'parent' => $this->when($this->resource->parent, function() {
                return $this->resource->parent ? new CommentResource($this->resource->parent) : null;
            }),
            'created_at' => $this->resource->created_at ?? null,
        ];
    }
}
