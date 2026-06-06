<?php

namespace App\Http\Middleware;

use App\Support\JwtClaims;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $next($request);
        }

        try {
            $tokenDecode = JWT::decode(
                $token,
                new Key(config('jwt.secret'), 'HS256')
            );

            // Store authenticated user id in request
            $request->merge([JwtClaims::USER_ID => $tokenDecode->sub]);
        } catch (\Exception $e) {
            // Invalid token — continue as unauthenticated
        }

        return $next($request);
    }
}
