<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeGenre extends Model
{
    protected $fillable = [
        'specs',
        'anime_id',
        'genre_id',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
