<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use App\Services\AuthService;

class MeQuery
{
    public function __construct(private readonly AuthService $authService) {}

    public function __invoke(mixed $root, array $args): ?User
    {
        return $this->authService->me();
    }
}
