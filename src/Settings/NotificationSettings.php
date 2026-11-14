<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;

class NotificationSettings extends Settings
{
    public array $admin_emails;
    public bool $contact_auto_reply_enabled;

    public static function group(): string
    {
        return 'notifications';
    }
}
