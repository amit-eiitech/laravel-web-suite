<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;

class ContactSettings extends Settings
{
    public ?string $public_email;
    public ?string $phone;
    public ?string $business_hours;

    public static function group(): string
    {
        return 'contact';
    }
}
