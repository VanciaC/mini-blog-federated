<?php

namespace App\Repositories\Interfaces;

use App\Models\Post;
use Illuminate\Support\Enumerable;

interface PostRepositoryInterface
{
    public function findAll(): Enumerable;

    public function findById(int $id): ?Post;

    public function save(Post $post): Post;
}
