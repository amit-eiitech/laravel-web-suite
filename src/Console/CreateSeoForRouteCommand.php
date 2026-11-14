<?php

namespace Eii\WebSuite\Console;

use Eii\WebSuite\Models\SeoMetadata;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class CreateSeoForRouteCommand extends Command
{
    protected $signature = 'web-suite:seo:create {route-name : Named route to attach SEO to}';

    protected $description = 'Create or fetch SEO metadata for a named route (custom page)';

    public function handle(): int
    {
        $routeName = $this->argument('route-name');

        if (! Route::has($routeName)) {
            $this->components->error("Route '{$routeName}' does not exist or is not named. Define it before creating SEO metadata.");
            return self::FAILURE;
        }

        $seo = SeoMetadata::firstOrCreate(['route_name' => $routeName]);

        $this->components->info("SEO metadata is ready for route '{$routeName}'.");
        $this->components->twoColumnDetail('ID', $seo->id);
        $this->components->twoColumnDetail('Route Name', $seo->route_name);

        return self::SUCCESS;
    }
}
