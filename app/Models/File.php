<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'specs',
        'fileable_id',
        'fileable_type',
        'name',
        'mimetype',
        'type',
        'size',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
