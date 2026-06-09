<?php

namespace Tests\Unit\Services;

use App\DTO\AuthPayload;
use App\DTO\RegisterUserDto;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Auth\AuthManager;
use Mockery;
use Mockery\MockInterface;
use RuntimeException;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;

class AuthServiceTest extends TestCase
{
    private MockInterface $userRepository;

    private MockInterface $jwt;

    private MockInterface $authManager;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->jwt = Mockery::mock(JWT::class);
        $this->authManager = Mockery::mock(AuthManager::class);

        $this->authService = new AuthService(
            userRepository: $this->userRepository,
            jwt: $this->jwt,
            authManager: $this->authManager,
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_register_returns_auth_payload(): void
    {
        $dto = new RegisterUserDto(name: 'Kanon', email: 'kanon@test.com', password: 'secret');
        $user = new User(['name' => 'Kanon', 'email' => 'kanon@test.com']);

        $this->userRepository
            ->shouldReceive('save')
            ->once()
            ->andReturn($user);

        $this->jwt
            ->shouldReceive('fromUser')
            ->once()
            ->with($user)
            ->andReturn('fake-token');

        $result = $this->authService->register($dto);

        $this->assertInstanceOf(AuthPayload::class, $result);
        $this->assertEquals('fake-token', $result->token);
        $this->assertEquals($user, $result->user);
    }

    public function test_register_hashes_password(): void
    {
        $dto = new RegisterUserDto(name: 'Kanon', email: 'kanon@test.com', password: 'secret');

        $this->userRepository
            ->shouldReceive('save')
            ->once()
            ->andReturnUsing(function (User $user) {
                $this->assertTrue(password_verify('secret', $user->password));

                return $user;
            });

        $this->jwt
            ->shouldReceive('fromUser')
            ->once()
            ->andReturn('fake-token');

        $this->authService->register($dto);
    }

    public function test_login_returns_auth_payload(): void
    {
        $user = new User(['name' => 'Kanon', 'email' => 'kanon@test.com']);
        $guard = Mockery::mock();

        $this->authManager
            ->shouldReceive('guard')
            ->with('api')
            ->andReturn($guard);

        $guard->shouldReceive('attempt')
            ->once()
            ->andReturn('fake-token');

        $guard->shouldReceive('user')
            ->once()
            ->andReturn($user);

        $result = $this->authService->login('kanon@test.com', 'secret');

        $this->assertInstanceOf(AuthPayload::class, $result);
        $this->assertEquals('fake-token', $result->token);
    }

    public function test_login_throws_exception_on_invalid_credentials(): void
    {
        $guard = Mockery::mock();

        $this->authManager
            ->shouldReceive('guard')
            ->with('api')
            ->andReturn($guard);

        $guard->shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid credentials.');

        $this->authService->login('kanon@test.com', 'wrong-password');
    }

    public function test_me_returns_authenticated_user(): void
    {
        $user = new User(['name' => 'Kanon', 'email' => 'kanon@test.com']);
        $guard = Mockery::mock();

        $this->authManager
            ->shouldReceive('guard')
            ->with('api')
            ->andReturn($guard);

        $guard->shouldReceive('user')
            ->once()
            ->andReturn($user);

        $result = $this->authService->me();

        $this->assertEquals($user, $result);
    }
}
