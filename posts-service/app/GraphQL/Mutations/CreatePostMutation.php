<?php

namespace App\GraphQL\Mutations;

use App\DTO\CreatePostDTO;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Auth\AuthManager;

class CreatePostMutation
{
    public function __construct(
        private readonly PostService $postService,
        private readonly AuthManager $auth,
    ) {}

    public function __invoke(mixed $root, array $args): Post
    {
        return $this->postService->create(
            new CreatePostDTO(
                title: $args['title'],
                body: $args['body'],
                authorId: $this->auth->guard('api')->id(),
            )
        );
    }
}
