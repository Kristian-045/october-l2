<?php namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;
use October\Rain\Database\Traits\Validation;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Reaction extends Model
{
    use Validation;

    public $table = 'appchat_chat_reactions';

    protected $fillable = [
        'emoji',
        'message_id',
        'user_id',
    ];

    public $rules = [
        'emoji' => 'required|string',
        'message_id' => 'required|exists:appchat_chat_messages,id',
        'user_id' => 'required|exists:appuser_user_users,id',
    ];

    public $belongsTo = [
        'user' => User::class,
        'message' => Message::class,
    ];

    public function getEmojiOptions()
    {
        $emojis = ReactionSetting::get('available_emojis', []);

        $options = [];
        foreach ($emojis as $item) {
            $options[$item['emoji']] = $item['emoji'];
        }

        return $options;
    }
}
