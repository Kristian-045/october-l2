<?php

namespace AppChat\Chat\Http\Controllers;

use App;
use AppUser\User\Models\User;

class ConversationUserController
{
    public function attach($id)
    {
        $authUser = App::make('authUser');
        //here should be just Conversation::findorfail and check should be in policy
        $conversation = $authUser->conversations()->findOrFail($id);

        $userIds = post('user_ids');

        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }

        if (empty($userIds) || !is_array($userIds)) {
            return response()->json(['message' => 'user_ids must be a non-empty array'], 422);
        }

        //todo where this should be should i create request like in normal laravel app?
        $existingCount = User::whereIn('id', $userIds)->count();
        if ($existingCount !== count($userIds)) {
            return response()->json(['message' => 'Some users do not exist'], 422);
        }

        $conversation->users()->syncWithoutDetaching($userIds);

        return response()->json(['message' => 'Users attached successfully']);
    }

    public function detach($id)
    {
        $authUser = App::make('authUser');
        $conversation = $authUser->conversations()->findOrFail($id);

        $userIds = post('user_ids');

        if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
        }

        $conversation->users()->detach($userIds);
        return response()->json(['message' => 'User detached successfully']);
    }
}
