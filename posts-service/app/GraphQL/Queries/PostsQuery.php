<?php

namespace App\GraphQL\Queries;

use App\Services\PostService;
use Illuminate\Support\Enumerable;

class PostsQuery
{
    public function __construct(private readonly PostService $postService) {}

    public function __invoke(mixed $root, array $args): Enumerable
    {
        return $this->postService->getAll();
    }
}