<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlackList
 *
 * @property int id
 * @property int user_id
 * @property int blocked_id
 * @property datetime timestamps
 *
 * @package App/Models
 */
class BlackList extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array|string[]
     */
    protected $fillable = [
        'user_id',
        'blocked_id'
    ];
    /**
     * @var array|string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'blocked_id' => 'integer',
    ];
}
