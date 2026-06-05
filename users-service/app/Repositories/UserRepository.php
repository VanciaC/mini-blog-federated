<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements Interfaces\UserRepositoryInterface
{
    public function __construct(private readonly User $user) {}

    public function findByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return $this->user->find($id);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user->refresh();
    }
}
