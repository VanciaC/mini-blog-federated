<?php

namespace Tests\Feature\GraphQL;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, Helpers;

    public function test_create_post_returns_post(): void
    {
        $response = $this->postJson('/graphql', [
            'query' => '
                mutation {
                    createPost(title: "Hello", body: "World") {
                        id
                        title
                        body
                        authorId
                        createdAt
                    }
                }
            ',
        ], $this->authHeader(1));

        $response->assertJsonPath('data.createPost.title', 'Hello');
        $response->assertJsonPath('data.createPost.body', 'World');
        $this->assertDatabaseHas('posts', ['title' => 'Hello']);
    }

    public function test_posts_returns_all_posts(): void
    {
        Post::factory()->count(3)->create();

        $response = $this->postJson('/graphql', [
            'query' => '
                {
                    posts {
                        id
                        title
                        body
                        authorId
                        createdAt
                    }
                }
            ',
        ]);

        $response->assertJsonPath('data.posts', fn($posts) => count($posts) === 3);
    }

    public function test_post_returns_single_post(): void
    {
        $post = Post::factory()->create(['title' => 'Mon post']);

        $response = $this->postJson('/graphql', [
            'query' => "
                {
                    post(id: {$post->id}) {
                        id
                        title
                        body
                        authorId
                        createdAt
                    }
                }
            ",
        ]);

        $response->assertJsonPath('data.post.title', 'Mon post');
    }

    public function test_post_returns_null_when_not_found(): void
    {
        $response = $this->postJson('/graphql', [
            'query' => '
                {
                    post(id: 999) {
                        id
                        title
                    }
                }
            ',
        ]);

        $response->assertJsonPath('data.post', null);
    }
}