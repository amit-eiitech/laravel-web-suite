<?php

namespace Eii\WebSuite\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'web-suite:install {--force : Replace the published config file}';

    protected $description = 'Install the Eii Web Suite package.';

    public function handle(): int

    {
        $this->components->info('Installing Eii Web Suite...');
        $this->newLine();

        $this->publishConfig();

        $this->newLine();
        $this->components->info('Running migrations...');
        $this->call('migrate');

        $this->newLine();
        $this->components->info('Eii Web Suite installed successfully!');
        $this->line('Filament UI is controlled by config("eii-web-suite.filament_resources") / env EII_FILAMENT_RESOURCES (default: enabled).');

        return self::SUCCESS;
    }


    protected function publishConfig(): void
    {
        $target = config_path('eii-web-suite.php');

        if (File::exists($target) && ! $this->option('force')) {
            $this->components->info('Configuration already exists. Skipping...');
        } else {
            $this->call('vendor:publish', [
                '--tag' => 'eii-web-suite-config',
                '--force' => (bool) $this->option('force'),
            ]);
        }
    }
}
