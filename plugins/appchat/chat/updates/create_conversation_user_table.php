<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateAppchatChatConversationUserTable Migration
 *
 * @link https://docs.octobercms.com/4.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_conversation_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')
                ->constrained(table: 'appchat_chat_conversations')
                ->cascadeOnDelete();
            $table
                ->foreignId('user_id')
                ->constrained(table: 'appuser_user_users')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['conversation_id', 'user_id']);
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_appchat_chat_conversation_user');
    }
};
