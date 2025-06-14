<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimeSeason extends Model
{
    use HasFactory;

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
