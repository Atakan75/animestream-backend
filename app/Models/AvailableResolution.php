<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableResolution extends Model
{
    protected $fillable = [
        'video_id',
        'resolution',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
