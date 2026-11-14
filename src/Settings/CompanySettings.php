<?php

namespace Eii\WebSuite\Settings;

use Spatie\LaravelSettings\Settings;


class CompanySettings extends Settings
{
    public string $company_name;
    public ?string $representative_name;
    public ?string $postal_code;
    public ?string $prefecture;
    public ?string $address;
    public ?string $registration_number;

    public static function group(): string
    {
        return 'company';
    }
}
