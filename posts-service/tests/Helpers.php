<?php

namespace Tests;

use Firebase\JWT\JWT;

trait Helpers
{
    private function makeToken(int $userId = 1): string
    {
        $key = config('jwt.secret');

        $payload = [
            'sub' => $userId,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $jwt = new JWT();

        return $jwt->encode($payload, $key, 'HS256');
    }

    private function authHeader(int $userId = 1): array
    {
        return ['Authorization' => 'Bearer ' . $this->makeToken($userId)];
    }
}
