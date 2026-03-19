<?php

namespace AppChat\Chat\Http\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'emoji' => $this->emoji,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'created_at' => $this->created_at,
        ];
    }
}
