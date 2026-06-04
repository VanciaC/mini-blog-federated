<?php

namespace App\Services;

use App\DTO\AuthPayload;
use App\DTO\RegisterUserDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\AuthManager;
use RuntimeException;
use Tymon\JWTAuth\JWT;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly JWT $jwt,
        private readonly AuthManager $authManager,
    ) {}

    public function register(RegisterUserDTO $registerUserDto): AuthPayload
    {
        $user           = new User();
        $user->name     = $registerUserDto->name;
        $user->email    = $registerUserDto->email;
        $user->password = bcrypt($registerUserDto->password);

        $user  = $this->userRepository->save($user);
        $token = $this->jwt->fromUser($user);

        return new AuthPayload(
            token: $token,
            user:  $user,
        );
    }

    public function login(string $email, string $password): AuthPayload
    {
        $token = $this->jwt->attempt([
            'email'    => $email,
            'password' => $password,
        ]);

        if (!$token) {
            throw new RuntimeException('Invalid credentials.');
        }

        return new AuthPayload(
            token: $token,
            user:  $this->authManager->guard('api')->user(),
        );
    }

    public function me(): ?User
    {
        return $this->authManager->guard('api')->user();
    }
}