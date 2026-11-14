<?php

namespace Eii\WebSuite;

use Eii\WebSuite\Filament\WebSuitePlugin;

class WebSuite
{
    /**
     * Get all active Filament resources.
     *
     * @param array<int|string, string|bool>|null $modules
     * @return array<class-string>
     */
    public static function getResources(?array $modules = null): array
    {
        return WebSuitePlugin::make($modules)->getResources();
    }

    /**
     * Get all Filament settings pages.
     *
     * @param array<int|string, string|bool>|null $modules
     * @return array<class-string>
     */
    public static function getPages(?array $modules = null): array
    {
        return WebSuitePlugin::make($modules)->getPages();
    }
}
