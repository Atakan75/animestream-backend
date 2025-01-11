<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWatchHistory extends Model
{
    protected $fillable = [
        'specs',
        'user_id',
        'anime_id',
        'episode_id',
        'watched_at',
        'duration_watched',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    public function episode()
    {
        return $this->belongsTo(AnimeEpisode::class, 'anime_episode_id');
    }
}
