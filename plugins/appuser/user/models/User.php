<?php namespace AppUser\User\Models;

use AppChat\Chat\Models\Conversation;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Reaction;
use Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;

    public $table = 'appuser_user_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:appuser_user_users,email',
        'password' => 'required|string|min:6',
    ];

    protected $hashable = ['password'];

    public $belongsToMany = [
        'conversations' => [
            Conversation::class,
            'table' => 'appchat_chat_conversation_user',
        ]
    ];

    public $hasMany = [
        'messages' => [Message::class],
        'reactions' => [Reaction::class]
    ];
}
