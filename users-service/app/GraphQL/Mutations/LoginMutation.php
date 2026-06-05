<?php

namespace App\GraphQL\Mutations;

use App\DTO\AuthPayload;
use App\Services\AuthService;

class LoginMutation
{
    public function __construct(private readonly AuthService $authService) {}

    public function __invoke(mixed $root, array $args): AuthPayload
    {
        return $this->authService->login(
            email:    $args['email'],
            password: $args['password'],
        );
    }
}