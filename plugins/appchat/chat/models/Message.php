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
        'message',
        'conversation_id',
        'user_id',
        'reply_to',
    ];

    public $rules = [
        'conversation_id' => 'required|exists:appchat_chat_conversations,id',
        'user_id' => 'required|exists:appuser_user_users,id',
        'reply_to' => 'nullable|integer|exists:appchat_chat_messages,id',
        'message' => 'required|string',
        'files' => 'nullable|array',
        'files.*' => 'file',
    ];

    public $belongsTo = [
        'conversation' => Conversation::class,
        'user' => User::class,
        'replyTo' => [Message::class, 'key' => 'reply_to'],
    ];

    public $hasMany = [
        'reactions' => Reaction::class,
    ];

    public $attachMany = [
        'files' => File::class,
    ];

    public function scopeInConversation($query, $model)
    {
        //model Message
        $conversationId = $model->conversation_id;
        //model Reaction
        if (!$conversationId) {
            $messageId = $model->message_id;
            if ($messageId) {
                $conversationId = self::find($messageId)->conversation_id;
            }
        }

        if ($conversationId) {
            $query->where('appchat_chat_messages.conversation_id', $conversationId);
        }
    }
}
