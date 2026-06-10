<?php

namespace Tests\Unit\Services;

use App\DTO\CreatePostDto;
use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\PostService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    private MockInterface $postRepository;

    private PostService $postService;

    public function test_get_all_returns_posts(): void
    {
        $posts = collect([
            new Post(['title' => 'Post 1', 'body' => 'Body 1']),
            new Post(['title' => 'Post 2', 'body' => 'Body 2']),
        ]);

        $this->postRepository
            ->shouldReceive('findAll')
            ->once()
            ->andReturn($posts);

        $result = $this->postService->getAll();

        $this->assertCount(2, $result);
    }

    public function test_get_by_id_returns_post(): void
    {
        $post = new Post(['title' => 'Post 1', 'body' => 'Body 1']);

        $this->postRepository
            ->shouldReceive('findById')
            ->once()
            ->with(1)
            ->andReturn($post);

        $result = $this->postService->getById(1);

        $this->assertEquals($post, $result);
    }

    public function test_get_by_id_returns_null_when_not_found(): void
    {
        $this->postRepository
            ->shouldReceive('findById')
            ->once()
            ->with(999)
            ->andReturn(null);

        $result = $this->postService->getById(999);

        $this->assertNull($result);
    }

    public function test_create_returns_post(): void
    {
        $dto = new CreatePostDto(
            title: 'Hello',
            body: 'World',
            authorId: 1,
            createdAt: now()->toDateTimeString(),
        );

        $post = new Post([
            'title' => 'Hello',
            'body' => 'World',
            'author_id' => 1,
        ]);

        $this->postRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn($post);

        $result = $this->postService->create($dto);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals('Hello', $result->title);
        $this->assertEquals('World', $result->body);
    }

    public function test_create_sets_correct_author_id(): void
    {
        $dto = new CreatePostDto(
            title: 'Hello',
            body: 'World',
            authorId: 42,
            createdAt: now()->toDateTimeString(),
        );

        $this->postRepository
            ->shouldReceive('save')
            ->once()
            ->andReturnUsing(function (Post $post) {
                $this->assertEquals(42, $post->author_id);

                return $post;
            });

        $this->postService->create($dto);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepository = Mockery::mock(PostRepositoryInterface::class);

        $this->postService = new PostService(
            postRepository: $this->postRepository,
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
