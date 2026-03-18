<?php namespace AppChat\Chat\Models;

use Model;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/4.x/extend/system/models.html
 */
class Reaction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_reactions';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
