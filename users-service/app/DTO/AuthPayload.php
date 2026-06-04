<?php

namespace App\DTO;

use App\Models\User;

class AuthPayload
{
    public function __construct(
        public readonly string $token,
        public readonly User $user,
    ) {}
}