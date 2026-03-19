<?php

namespace AppChat\Chat\Http\Controllers;

use App;
use AppChat\Chat\Http\resources\MessageResource;
use AppChat\Chat\Models\Conversation;
use AppChat\Chat\Models\Message;
use Db;
use Illuminate\Http\JsonResponse;

class MessageController
{
    public function index(int $conversation_id): JsonResponse
    {
        $user = App::make('authUser');
        $conversation = Conversation::findOrFail($conversation_id);

        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(
            MessageResource::collection(
                $conversation->messages()
                    ->with(['reactions', 'files', 'replyTo', 'user'])
                    ->latest()
                    ->paginate(100)
            )
        );
    }

    public function store(int $conversation_id)
    {
        $user = App::make('authUser');
        $conversation = Conversation::findOrFail($conversation_id);

        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return DB::transaction(function () use ($user, $conversation) {
            $message = new Message();
            $message->message = post('message');
            $message->reply_to = post('reply_to') ?: null;
            $message->user_id = $user->id;
            $message->conversation_id = $conversation->id;
            $message->save();

            $message->files = (array)files('files');
            $message->save();

            return response()->json(
                new MessageResource($message->load(['reactions', 'files', 'replyTo', 'user']))
            );
        });
    }

    public function destroy($conversation_id, $id)
    {
        $user = App::make('authUser');
        $conversation = Conversation::findOrFail($conversation_id);

        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message = $conversation->messages()->where('user_id', $user->id)->find($id);

        if (!$message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted']);
    }
}
