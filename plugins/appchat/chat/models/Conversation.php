<?php namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Conversation Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Conversation extends Model
{
    use Validation;

    public $table = 'appchat_chat_conversations';

    protected $fillable = [
        'name',
    ];

    public $rules = [
        'name' => 'required|string|max:255',
    ];

    public $belongsToMany = [
        'users' => [
            User::class,
            'table' => 'appchat_chat_conversation_user',
        ]
    ];

    public $hasMany = [
        'messages' => [Message::class]
    ];
}
