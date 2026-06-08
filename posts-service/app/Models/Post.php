<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $author_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'author_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
