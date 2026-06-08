<?php

namespace App\Services;

use App\DTO\CreatePostDTO;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Support\Enumerable;

class PostService
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function getAll(): Enumerable
    {
        return $this->postRepository->findAll();
    }

    public function getById(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }

    public function create(CreatePostDTO $dto): Post
    {
        $post = new Post;
        $post->title = $dto->title;
        $post->body = $dto->body;
        $post->author_id = $dto->authorId;

        return $this->postRepository->save($post);
    }
}
