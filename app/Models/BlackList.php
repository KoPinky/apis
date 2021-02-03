<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlackList
 * 
 * @property int user_id
 * @property int blocked_id
 * 
 * @package App/Models
 */
class BlackList extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'blocked_id'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'blocked_id' => 'integer',
    ];
}
