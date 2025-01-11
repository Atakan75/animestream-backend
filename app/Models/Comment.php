<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'specs',
        'user_id',
        'parent_id',
        'commentable_id',
        'comment_type_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        //return $this->belongsTo(Comment::class, 'parent_id');
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function commentType()
    {
        return $this->belongsTo(CommentType::class);
    }
}
