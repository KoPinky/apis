<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * 
 * @property int user_id
 * @property int post_id
 * @property string text
 * 
 * @package App/Models
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'text',
        
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
    ];
}
