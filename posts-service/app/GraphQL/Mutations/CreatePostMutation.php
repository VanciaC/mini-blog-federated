<?php

namespace App\GraphQL\Mutations;

use App\DTO\CreatePostDto;
use App\Models\Post;
use App\Services\PostService;
use App\Support\JwtClaims;
use Illuminate\Http\Request;
use RuntimeException;

class CreatePostMutation
{
    public function __construct(
        private readonly PostService $postService,
        private readonly Request $request,
    ) {}

    public function __invoke(mixed $root, array $args): Post
    {

        $authorId = $this->request->input(JwtClaims::USER_ID);

        if (! $authorId) {
            throw new RuntimeException('Unauthenticated.');
        }

        return $this->postService->create(
            new CreatePostDto(
                title: $args['title'],
                body: $args['body'],
                authorId: (int) $authorId,
                createdAt: now(),
            )
        );
    }
}
