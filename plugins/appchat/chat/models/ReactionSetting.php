<?php

namespace AppChat\Chat\Models;

use System\Models\SettingModel;

class ReactionSetting extends SettingModel
{
    public $settingsCode = '';

    public $settingsFields = 'fields.yaml';

    public $rules = [
        'available_emojis.*.emoji' => 'required|string',
    ];

}
