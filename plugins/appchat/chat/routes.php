<?php

use AppChat\Chat\Models\Conversation;

Route::get('test', function () {

    return Conversation::find(1)->messages;
});
