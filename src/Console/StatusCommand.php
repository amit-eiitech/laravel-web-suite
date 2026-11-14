<?php

namespace Eii\WebSuite\Console;

use Illuminate\Console\Command;

class StatusCommand extends Command
{
    protected $signature = 'web-suite:status';

    protected $description = 'Show the Eii Web Suite environment status.';

    public function handle(): int
    {
        $this->table(
            ['Check', 'Status'],
            [
                ['Laravel', app()->version()],
                ['PHP', PHP_VERSION],
                ['Database connection', config('database.default')],
                ['Filament 5 installed', class_exists(\Filament\Panel::class) ? 'Yes' : 'No'],
            ]
        );

        return self::SUCCESS;
    }
}
