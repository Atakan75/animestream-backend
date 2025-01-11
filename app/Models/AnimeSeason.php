<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeSeason extends Model
{
    protected $fillable = [
        'specs',
        'anime_id',
        'name',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    public function episodes()
    {
        return $this->hasMany(AnimeEpisode::class, 'season_id');
    }
}
