<?php

namespace AppChat\Chat\Http\Controllers;

use App;
use AppChat\Chat\Models\Conversation;
use DB;
use Illuminate\Http\JsonResponse;

class ConversationController
{
    public function index(): JsonResponse
    {
        return response()->json(
            App::make('authUser')
                ->conversations()
                ->with('users')
                ->with(['messages' => function ($query) {
                    $query->latest()->limit(1);
                }])
                ->get()
        );
    }

    public function show($id): JsonResponse
    {
        $conversation = Conversation::findOrFail($id);
        $user = App::make('authUser');
        //this should be in policy
        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->load('users');
        $conversation->load(['messages' => function ($query) {
            $query->latest()->limit(100)->with(['reactions', 'files']);
        }]);

        return response()->json($conversation);
    }

    public function store(): JsonResponse
    {
        $user = App::make('authUser');

        return DB::transaction(function () use ($user) {
            $conversation = new Conversation();
            $conversation->name = post('name') ?? 'Conversation';
            $conversation->save();
            $conversation->users()->attach($user->id);
            return response()->json($conversation);
        });
    }

    public function update($id): JsonResponse
    {
        $conversation = Conversation::findOrFail($id);
        $user = App::make('authUser');

        //this should be in policy
        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->name = post('name');
        $conversation->save();

        return response()->json($conversation);
    }

    public function destroy($id): JsonResponse
    {
        $conversation = Conversation::findOrFail($id);
        $user = App::make('authUser');

        //this should be in policy
        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $conversation->delete();
        return response()->json(['message' => 'Conversation deleted']);
    }
}
