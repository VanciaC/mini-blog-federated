<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Enumerable;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(private readonly Post $post) {}

    public function findAll(): Enumerable
    {
        return $this->post->all();
    }

    public function findById(int $id): ?Post
    {
        return $this->post->find($id);
    }

    public function save(Post $post): Post
    {
        $post->save();
        return $post->refresh();
    }
}