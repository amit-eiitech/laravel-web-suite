<?php

namespace Eii\WebSuite;

use Eii\WebSuite\Console\CreateSeoForRouteCommand;
use Eii\WebSuite\Console\InstallCommand;
use Eii\WebSuite\Console\StatusCommand;
use Eii\WebSuite\Http\Middleware\HandleSeoRedirects;
use Eii\WebSuite\Http\Middleware\ResolveSeoMetadata;
use Eii\WebSuite\Models\BlogPost;
use Eii\WebSuite\Models\Event;
use Eii\WebSuite\Models\JobPost;
use Eii\WebSuite\Models\News;
use Eii\WebSuite\Policies\BlogPostPolicy;
use Eii\WebSuite\Policies\EventPolicy;
use Eii\WebSuite\Policies\JobPostPolicy;
use Eii\WebSuite\Policies\NewsPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class WebSuiteServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/eii-web-suite.php',
            'eii-web-suite'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'eii-web-suite');

        if (config()->has('settings.auto_discover_settings')) {
            $paths = config('settings.auto_discover_settings', []);
            $paths[] = __DIR__ . '/Settings';
            config(['settings.auto_discover_settings' => array_values(array_unique($paths))]);
        }

        if (config()->has('settings.migrations_paths')) {
            $paths = config('settings.migrations_paths', []);
            $paths[] = __DIR__ . '/../database/settings';
            config(['settings.migrations_paths' => array_values(array_unique($paths))]);
        }

        $this->publishes([
            __DIR__ . '/../config/eii-web-suite.php' => config_path('eii-web-suite.php'),
        ], 'eii-web-suite-config');

        $router = $this->app['router'];
        $router->aliasMiddleware('web-suite.seo', ResolveSeoMetadata::class);
        $router->aliasMiddleware('web-suite.seo.redirect', HandleSeoRedirects::class);
        $router->pushMiddlewareToGroup('web', HandleSeoRedirects::class);
        $router->pushMiddlewareToGroup('web', ResolveSeoMetadata::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                StatusCommand::class,
                CreateSeoForRouteCommand::class,
            ]);
        }

        // Policies (register only when the host app has not defined one)
        $this->registerDefaultPolicy(News::class, NewsPolicy::class);
        $this->registerDefaultPolicy(Event::class, EventPolicy::class);
        $this->registerDefaultPolicy(BlogPost::class, BlogPostPolicy::class);
        $this->registerDefaultPolicy(JobPost::class, JobPostPolicy::class);
    }

    protected function registerDefaultPolicy(string $modelClass, string $policyClass): void
    {
        if (Gate::getPolicyFor($modelClass)) {
            return;
        }

        Gate::policy($modelClass, $policyClass);
    }
}
