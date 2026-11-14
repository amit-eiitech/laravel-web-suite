<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public ?string $default_title;
    public ?string $default_description;
    public ?string $default_og_image;
    public bool $allow_indexing;

    public static function group(): string
    {
        return 'seo';
    }
}
