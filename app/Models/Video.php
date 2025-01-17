<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'specs',
        'status',
        'hls_path',
    ];

    public function resolutions()
    {
        return $this->hasMany(AvailableResolution::class);
    }
}
