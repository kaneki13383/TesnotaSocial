<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function photo_post()
    {
        return $this->belongsTo(PhotoPost::class, 'id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_post');
    }
}
