<?php

namespace AppChat\Chat\Http\resources;

use AppUser\User\Http\resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'user' => new UserResource($this->whenLoaded('user')),
            'reply_to' => new MessageResource($this->whenLoaded('replyTo')),
            'reactions' => ReactionResource::collection($this->whenLoaded('reactions')),
            'files' => $this->whenLoaded('files', function () {
                return $this->files->map(fn($file) => [
                    'id' => $file->id,
                    'url' => $file->getPath(),
                    'name' => $file->file_name,
                ]);
            }),
            'created_at' => $this->created_at,
        ];
    }
}
