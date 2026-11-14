<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;

class LocalizationSettings extends Settings
{
    public string $default_locale;
    public string $timezone;
    public string $date_format;

    public static function group(): string
    {
        return 'localization';
    }
}
