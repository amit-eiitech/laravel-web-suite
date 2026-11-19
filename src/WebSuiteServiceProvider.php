<?php

namespace Eii\WebSuite;

use Eii\WebSuite\Console\CreateSeoForRouteCommand;
use Eii\WebSuite\Console\InstallCommand;
use Eii\WebSuite\Console\StatusCommand;
use Eii\WebSuite\Http\Middleware\HandleSeoRedirects;
use Eii\WebSuite\Http\Middleware\ResolveSeoMetadata;
use Eii\WebSuite\Models\BlogPost;
use Eii\WebSuite\Models\Event;
use Eii\WebSuite\Models\Faq;
use Eii\WebSuite\Models\JobPost;
use Eii\WebSuite\Models\News;
use Eii\WebSuite\Policies\BlogPostPolicy;
use Eii\WebSuite\Policies\EventPolicy;
use Eii\WebSuite\Policies\FaqPolicy;
use Eii\WebSuite\Policies\JobPostPolicy;
use Eii\WebSuite\Policies\NewsPolicy;
use Illuminate\Routing\Router;
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

        $this->app->booted(function (): void {
            /** @var Router $router */
            $router = $this->app['router'];

            $router->aliasMiddleware('web-suite.seo', ResolveSeoMetadata::class);
            $router->aliasMiddleware('web-suite.seo.redirect', HandleSeoRedirects::class);

            $this->pushMiddlewareToGroupOnce($router, 'web', HandleSeoRedirects::class);
            $this->pushMiddlewareToGroupOnce($router, 'web', ResolveSeoMetadata::class);
        });

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
        $this->registerDefaultPolicy(Faq::class, FaqPolicy::class);
    }

    protected function registerDefaultPolicy(string $modelClass, string $policyClass): void
    {
        if (Gate::getPolicyFor($modelClass)) {
            return;
        }

        Gate::policy($modelClass, $policyClass);
    }

    protected function pushMiddlewareToGroupOnce(Router $router, string $group, string $middleware): void
    {
        $existing = $router->getMiddlewareGroups()[$group] ?? [];

        if (in_array($middleware, $existing, true)) {
            return;
        }

        $router->pushMiddlewareToGroup($group, $middleware);
    }
}
