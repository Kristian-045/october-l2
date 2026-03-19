<?php

namespace AppChat\Chat\Http\Controllers;

use App;
use AppChat\Chat\Http\resources\ReactionResource;
use AppChat\Chat\Models\Conversation;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Reaction;
use AppChat\Chat\Models\ReactionSetting;
use Illuminate\Http\JsonResponse;

class ReactionController
{
    public function emojis(): JsonResponse
    {
        $emojis = ReactionSetting::get('available_emojis', []);
        return response()->json([
            'emojis' => array_column($emojis, 'emoji')
        ]);
    }

    public function index(int $conversation_id, int $message_id): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversation_id);
        $message = Message::findOrFail($message_id);
        $this->checkAccess($conversation, $message);

        return response()->json(
            ReactionResource::collection($message->reactions()->with('user')->get())
        );
    }

    public function store(int $conversation_id, int $message_id): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversation_id);
        $message = Message::findOrFail($message_id);
        $this->checkAccess($conversation, $message);

        $user = App::make('authUser');

        $emoji = post('emoji');
        $emojis = array_column(ReactionSetting::get('available_emojis', []), 'emoji');

        if (!in_array($emoji, $emojis)) {
            return response()->json(['message' => 'Invalid emoji'], 422);
        }

        $reaction = Reaction::updateOrCreate(
            ['message_id' => $message->id, 'user_id' => $user->id],
            ['emoji' => $emoji]
        );

        return response()->json(new ReactionResource($reaction));
    }

    public function destroy(int $conversation_id, int $message_id, int $reaction_id): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversation_id);
        $message = Message::findOrFail($message_id);
        $this->checkAccess($conversation, $message);

        $user = App::make('authUser');
        $reaction = Reaction::findOrFail($reaction_id);

        if ($reaction->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $reaction->delete();

        return response()->json(['message' => 'Reaction deleted']);
    }

    private function checkAccess(Conversation $conversation, Message $message): void
    {
        $user = App::make('authUser');

        if (!$conversation->users()->where('user_id', $user->id)->exists()) {
            abort(403, 'Unauthorized');
        }

        if ($message->conversation_id !== $conversation->id) {
            abort(404);
        }
    }
}
