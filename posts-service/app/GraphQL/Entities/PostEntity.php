<?php

namespace App\GraphQL\Entities;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostEntity
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository
    ) {}

    public function __invoke(array $reference): ?Post
    {
        return $this->postRepository->findById($reference['id']);
    }
}
