<?php

namespace AppUser\User\Http\middleware;

use AppUser\User\Models\User;
use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token || !User::where('token', $token)->first()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}
