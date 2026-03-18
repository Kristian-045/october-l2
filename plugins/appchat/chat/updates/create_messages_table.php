<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessagesTable Migration
 *
 * @link https://docs.octobercms.com/4.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->foreignId('conversation_id')
                ->constrained(table: 'appchat_chat_conversations')
                ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'appuser_user_users')
                ->nullOnDelete();
            $table->foreignId('reply_to')->nullable()
                ->constrained(table: 'appchat_chat_messages')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_messages');
    }
};
