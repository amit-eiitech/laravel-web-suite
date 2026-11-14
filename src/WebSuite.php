<?php

namespace Eii\WebSuite;

use Eii\WebSuite\Filament\Pages\CompanySettings;
use Eii\WebSuite\Filament\Pages\ContactSettings;
use Eii\WebSuite\Filament\Pages\GeneralSettings;
use Eii\WebSuite\Filament\Pages\LocalizationSettings;
use Eii\WebSuite\Filament\Pages\NotificationSettings;
use Eii\WebSuite\Filament\Pages\SeoSettings;
use Eii\WebSuite\Filament\Pages\SocialSettings;
use Eii\WebSuite\Filament\Resources\BlogPost\BlogPostResource;
use Eii\WebSuite\Filament\Resources\Category\CategoryResource;
use Eii\WebSuite\Filament\Resources\ContactForm\ContactFormResource;
use Eii\WebSuite\Filament\Resources\ContactSubmission\ContactSubmissionResource;
use Eii\WebSuite\Filament\Resources\Event\EventResource;
use Eii\WebSuite\Filament\Resources\Faq\FaqResource;
use Eii\WebSuite\Filament\Resources\JobPost\JobPostResource;
use Eii\WebSuite\Filament\Resources\News\NewsResource;
use Eii\WebSuite\Filament\Resources\SeoMetadata\SeoMetadataResource;
use Eii\WebSuite\Filament\Resources\SeoRedirect\SeoRedirectResource;

class WebSuite
{
    /**
     * Get all active Filament resources based on package configuration.
     *
     * @return array<class-string>
     */
    public static function getResources(): array
    {
        if (! static::areFilamentResourcesEnabled()) {
            return [];
        }

        return array_values(array_filter([
            static::isModuleEnabled('news') ? NewsResource::class : null,
            static::isModuleEnabled('events') ? EventResource::class : null,
            static::isModuleEnabled('recruitment') ? JobPostResource::class : null,
            static::isModuleEnabled('blog', false) ? BlogPostResource::class : null,
            static::isModuleEnabled('faqs') ? FaqResource::class : null,
            static::isModuleEnabled('categories', true) ? CategoryResource::class : null,
            static::isModuleEnabled('contact') ? ContactFormResource::class : null,
            static::isModuleEnabled('contact') ? ContactSubmissionResource::class : null,
            static::isModuleEnabled('seo') ? SeoMetadataResource::class : null,
            static::isModuleEnabled('seo') ? SeoRedirectResource::class : null,
        ]));
    }

    /**
     * Get all Filament settings pages based on package configuration.
     *
     * @return array<class-string>
     */
    public static function getPages(): array
    {
        if (! static::areFilamentResourcesEnabled()) {
            return [];
        }

        return array_values(array_filter([
            GeneralSettings::class,
            CompanySettings::class,
            static::isModuleEnabled('contact') ? ContactSettings::class : null,
            SocialSettings::class,
            LocalizationSettings::class,
            static::isModuleEnabled('seo') ? SeoSettings::class : null,
            NotificationSettings::class,
        ]));
    }

    /**
     * Determine if a given module is enabled in configuration.
     */
    public static function isModuleEnabled(string $module, bool $default = true): bool
    {
        return (bool) config("eii-web-suite.modules.{$module}", $default);
    }

    /**
     * Determine if Filament UI resources are enabled.
     */
    public static function areFilamentResourcesEnabled(): bool
    {
        return (bool) config('eii-web-suite.filament_resources', true);
    }
}
