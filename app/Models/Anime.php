<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        'specs',
        'user_id',
        'name',
        'slug',
        'release_date',
        'imdb_score',
        'summary',
    ];

    protected $casts = [
        'release_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seasons()
    {
        return $this->hasMany(AnimeSeason::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'anime_genres');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commentable_id')->where('comment_type_id', 1);
    }

    public function thumbnail()
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'anime_thumbnails');
    }
}
