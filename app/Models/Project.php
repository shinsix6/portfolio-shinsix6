<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'genre_id',
        'description',
        'image',
        'link',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
