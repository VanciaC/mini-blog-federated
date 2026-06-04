<?php

namespace App\GraphQL\Entities;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserEntity
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(array $reference): ?User
    {
        return $this->userRepository->findById($reference['id']);
    }
}