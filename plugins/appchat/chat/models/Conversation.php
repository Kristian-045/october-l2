<?php namespace AppChat\Chat\Models;

use Model;

/**
 * Conversation Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Conversation extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_conversations';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
