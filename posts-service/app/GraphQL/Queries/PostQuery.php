<?php

namespace App\GraphQL\Queries;

use App\Models\Post;
use App\Services\PostService;

class PostQuery
{
    public function __construct(private readonly PostService $postService) {}

    public function __invoke(mixed $root, array $args): ?Post
    {
        return $this->postService->getById((int) $args['id']);
    }
}
