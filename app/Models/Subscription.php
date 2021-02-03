<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * 
 * @property int user_id
 * @property int added_id
 * 
 * @package App/Models
 */
class Subscription extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'added_id'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'added_id' => 'integer',
    ];
}
