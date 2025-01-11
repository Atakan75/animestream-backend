<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeEpisode extends Model
{
    protected $fillable = [
        'specs',
        'anime_id',
        'season_id',
        'name',
        'slug',
        'summary',
        'duration',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    public function season()
    {
        return $this->belongsTo(AnimeSeason::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id');
    }

    public function thumbnail()
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'anime_episode_thumbnails');
    }

    public function video()
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'anime_episode_videos');
    }
}
