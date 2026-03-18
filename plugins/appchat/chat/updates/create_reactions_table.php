<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateReactionsTable Migration
 *
 * @link https://docs.octobercms.com/4.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_reactions', function (Blueprint $table) {
            $table->id();
            $table->string('emoji');
            $table->foreignId('message_id')
                ->constrained(table: 'appchat_chat_messages')
                ->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()
                ->constrained(table: 'appuser_user_users')
                ->nullOnDelete();
            $table->timestamps();

            $table->unique(['message_id', 'user_id']);
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_reactions');
    }
};
