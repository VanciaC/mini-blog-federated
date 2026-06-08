<?php

namespace App\GraphQL\Mutations;

use App\DTO\AuthPayload;
use App\DTO\RegisterUserDTO;
use App\Services\AuthService;

class RegisterMutation
{
    public function __construct(private readonly AuthService $authService) {}

    public function __invoke(mixed $root, array $args): AuthPayload
    {
        return $this->authService->register(
            new RegisterUserDTO(
                name: $args['name'],
                email: $args['email'],
                password: $args['password'],
            )
        );
    }
}
