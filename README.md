# Eii Web Suite

**Composer:** `eii/laravel-web-suite`

A modular Laravel package for the recurring backend functionality used in business websites. The core is independent of Filament. Filament 5 resources are an optional generated UI.

> This is the initial development scaffold, not a production-ready release. Review the security notes and complete the tests before using it with client data.

## Requirements

- PHP 8.2+
- Laravel 12 or 13
- `spatie/laravel-settings` 3.x
- Optional: Filament 5

## Local package development

In the Laravel application's `composer.json`, add a path repository:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../eii-web-suite",
            "options": {
                "symlink": true
            }
        }
    ]
}
```

Then install:

```bash
composer require eii/laravel-web-suite:@dev
```

For a published package:

```bash
composer require eii/laravel-web-suite
```

## First installation

```bash
php artisan eii:install
php artisan migrate
```

The package loads its regular migrations automatically. Its Spatie Settings classes and settings migration are also registered with Spatie's settings discovery paths. The installer publishes the package config if it does not already exist.
Spatie Laravel Settings must have its own `config/settings.php` and base settings-table migration published in the host application. If this is a fresh installation, run:
```bash
php artisan vendor:publish --provider="Spatie\\LaravelSettings\\LaravelSettingsServiceProvider" --tag="config"
php artisan vendor:publish --provider="Spatie\\LaravelSettings\\LaravelSettingsServiceProvider" --tag="migrations"
php artisan migrate
```
The package adds its own settings classes and settings migration path to Spatie's discovery configuration.

## Admin UI

The package provides pre-built Filament 5 resources and custom settings pages. You can integrate them into your `AdminPanelProvider` in three ways:

### Option 1: Filament Plugin (Recommended)

In your `app/Providers/Filament/AdminPanelProvider.php`:

```php
use Eii\WebSuite\Filament\WebSuitePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(WebSuitePlugin::make());
}
```

The plugin allows selecting exactly which modules to load directly from your panel provider, without needing to touch configuration:

#### A. Direct Module Whitelist (Only load specified modules)

```php
WebSuitePlugin::make([
    'news',
    'events',
    'blog',
    'contact',
    'seo',
])
```

Or using the fluent `modules()` method:

```php
WebSuitePlugin::make()
    ->modules([
        'news',
        'blog',
        'contact',
    ])
```

#### B. Fluent Chaining

```php
WebSuitePlugin::make()
    ->withBlog()
    ->withoutEvents()
    ->withoutRecruitment()
```

#### C. Associative Toggle Map

```php
WebSuitePlugin::make()
    ->modules([
        'news' => true,
        'blog' => true,
        'events' => false,
        'recruitment' => false,
    ])
```

### Option 2: Automatic Helper

```php
use Eii\WebSuite\WebSuite;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->resources(WebSuite::getResources())
        ->pages(WebSuite::getPages());
}
```

### Option 3: Manual Selection

Select only the exact resources you want:

```php
use Eii\WebSuite\Filament\Resources\News\NewsResource;
use Eii\WebSuite\Filament\Resources\Event\EventResource;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->resources([
            NewsResource::class,
            EventResource::class,
        ]);
}
```

## Current implementation status

Included in this scaffold:
- Package service provider and configuration.
- Install/status/generate Artisan commands.
- Initial content, contact, and SEO migrations.
- Eloquent models and basic relationships.
- Filament 5 Plugin (`WebSuitePlugin`) with per-module toggling.
- `WebSuite` helper class for resource/page discovery.
- Complete Filament 5 resources: News, Events, Job Openings, Blog Posts, FAQs, Categories, Contact Forms, Contact Submissions, SEO Metadata, SEO Redirects.
- Filament 5 custom settings pages: General, Company, Contact, Social, Localization, SEO, Notification.
- Full product plan in `PLAN.md`.

### Available fluent toggles for `WebSuitePlugin`

| Method | Default | Effect |
|---|---|---|
| `withBlog()` | Off | Enable Blog module resources |
| `withoutNews()` | On | Disable News resource |
| `withoutEvents()` | On | Disable Events resource |
| `withoutRecruitment()` | On | Disable Job Openings resource |
| `withoutBlog()` | Off | Disable Blog module (already off by default) |
| `withoutFaqs()` | On | Disable FAQs resource |
| `withoutCategories()` | On | Disable Categories resource |
| `withoutContact()` | On | Disable Contact Forms & Submissions resources + Contact Settings page |
| `withoutSeo()` | On | Disable SEO Metadata & Redirects resources + SEO Settings page |
| `withoutSettings()` | On | Disable all settings pages |

Still to implement:
- Feature tests and CI matrix.
- CAPTCHA adapters (Turnstile and reCAPTCHA).
- Contact form submission workflow and notification delivery.
- SEO rendering, sitemap generation, redirect middleware.
- Authorization policies and admin access integration.
