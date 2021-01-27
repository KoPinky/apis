<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme',
        'text',
        'pictures',
    ];

    protected $casts = [
        'user_id'=>'integer',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
