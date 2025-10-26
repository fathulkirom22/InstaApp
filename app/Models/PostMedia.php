<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $fillable = ['post_id','type','path','mime','order'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // accessor for full url (if you store relative path)
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
