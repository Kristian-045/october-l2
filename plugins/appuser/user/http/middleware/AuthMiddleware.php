<?php

namespace AppUser\User\Http\middleware;

use App;
use AppUser\User\Models\User;
use Closure;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        $user = User::where('token', $token)->first();

        if (!$token || !$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        App::instance('authUser', $user);

        return $next($request);
    }
}
