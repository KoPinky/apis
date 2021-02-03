<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int user_id
 * @property string theme
 * @property string text
 * @property object pictures
 * 
 * @package App/Models
 */
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
        'user_id' => 'integer',
    ];

}
