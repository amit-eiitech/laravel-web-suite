<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;

class SocialSettings extends Settings
{
    public ?string $x_url;
    public ?string $facebook_url;
    public ?string $instagram_url;
    public ?string $linkedin_url;
    public ?string $youtube_url;

    public static function group(): string
    {
        return 'social';
    }
}
