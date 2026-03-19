<?php namespace AppChat\Chat;

use AppChat\Chat\Models\ReactionSetting;
use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/4.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Chat',
            'description' => 'No description provided yet...',
            'author' => 'AppChat',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppChat\Chat\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'appchat.chat.some_permission' => [
                'tab' => 'Chat',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {

        return [
            'chat' => [
                'label' => 'Chat',
                'url' => Backend::url('appchat/chat/conversations'),
                'icon' => 'icon-comments',
                'permissions' => ['appchat.chat.*'],
                'order' => 500,
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'category' => 'Chat',
                'label' => 'Reaction settings',
                'description' => 'Manage available emoji reactions',
                'icon' => 'icon-smile-o',
                'class' => ReactionSetting::class,
                'order' => 500,
                'permissions' => ['appchat.chat.*'],
            ],
        ];
    }
}
