<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoPost extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
