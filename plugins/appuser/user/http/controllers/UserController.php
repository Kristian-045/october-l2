<?php

namespace AppUser\User\Http\Controllers;

use AppUser\User\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Request;
use Str;

class UserController
{

    public function register(): JsonResponse
    {
        $user = new User();
        $user->name = post('name');
        $user->email = post('email');
        $user->password = post('password');

        $user->token = Str::random(30);

        $user->save();

        return response()->json([
            'token' => $user->token,
            'user' => $user,
        ]);
    }

    public function login(): JsonResponse
    {
        $user = User::where('email', post('email'))->first();
        if (!$user || !Hash::check(post('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user->token = Str::random(30);
        $user->forceSave();

        return response()->json([
            'token' => $user->token,
            'user' => $user,
        ]);
    }

    public function logout()
    {
        $token = Request::bearerToken();
        $user = User::where('token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        $user->token = null;
        $user->forceSave();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
