<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $author_id
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'body',
        'author_id',
    ];

    protected $appends = ['authorId', 'createdAt', 'author'];

    public function getCreatedAtAttribute(): string
    {
        return (string) $this->attributes['created_at'];
    }

    public function getAuthorIdAttribute(): int
    {
        return (int) $this->attributes['author_id'];
    }

    public function getAuthorAttribute(): array
    {
        return ['id' => $this->attributes['author_id']];
    }
}
