<?php namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;
use October\Rain\Database\Traits\Validation;
use System\Models\File;

/**
 * Message Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Message extends Model
{
    use Validation;

    public $table = 'appchat_chat_messages';

    protected $fillable = [
        'body',
        'conversation_id',
        'user_id',
        'reply_to',
    ];

    public $rules = [
        'conversation_id' => 'required|exists:appchat_chat_conversations,id',
        'user_id' => 'required|exists:appuser_user_users,id',
        'reply_to' => 'nullable|exists:appchat_chat_messages,id',
        'message' => 'nullable|string',
    ];

    public $belongsTo = [
        'conversation' => Conversation::class,
        'user' => User::class,
        'reply_to' => Message::class,
    ];

    public $hasMany = [
        'reactions' => Reaction::class,
    ];

    public $attachMany= [
        'files' => File::class,
    ];

}
