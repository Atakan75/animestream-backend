<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'specs',
        'user_id',
        'meta_title',
        'meta_description',
        'title',
        'slug',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thumbnail()
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'blog_thumbnails');
    }
}
