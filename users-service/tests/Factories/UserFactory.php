<?php

namespace Tests\Factories;

use App\Models\User;

class UserFactory
{
    public function create(array $attributes = []): User
    {
        $user = new User;
        $user->name = $attributes['name'] ?? 'Kanon';
        $user->email = $attributes['email'] ?? 'kanon@example.com';
        $user->password = $attributes['password']
            ?? password_hash('password', PASSWORD_BCRYPT);

        $user->save();

        return $user;
    }
}
