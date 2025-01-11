<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentType extends Model
{
    protected $fillable = [
        'specs',
        'name',
    ];
}
