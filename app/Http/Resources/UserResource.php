<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name ? $this->name : null,
            'email' => $this->email ? $this->email : null,
            'avatar' => $this->avatar ? config('app.url') . '/storage/user_avatars/' . ($this->avatar->id == 1 ? "default" : md5($this->id)) . '/' . $this->avatar->name : config('app.url') . '/storage/user_avatars/default/' . File::where('id', 1)->first()->name,
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name')->toArray();
            }),
            'created_at' => $this->created_at ? $this->created_at : null,
            'updated_at' => $this->updated_at ? $this->updated_at : null,
        ];
    }
}
