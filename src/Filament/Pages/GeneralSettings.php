<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\GeneralSettings as Settings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class GeneralSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'General Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 1;

    protected string $view = 'eii-web-suite::filament.pages.general-settings';

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'site_name' => $settings->site_name,
            'logo_path' => $settings->logo_path,
            'favicon_path' => $settings->favicon_path,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Site Information')
                    ->description('General site identification details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The public name of the website'),
                    ]),

                Section::make('Branding')
                    ->description('Site logo and favicon')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo_path')
                            ->image()
                            ->directory('settings')
                            ->helperText('Primary logo for header and branding'),

                        FileUpload::make('favicon_path')
                            ->image()
                            ->directory('settings')
                            ->helperText('Favicon icon displayed in browser tabs'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->site_name = $state['site_name'];
        $settings->logo_path = $state['logo_path'] ?? null;
        $settings->favicon_path = $state['favicon_path'] ?? null;
        $settings->save();

        Notification::make()
            ->success()
            ->title('General settings saved')
            ->send();
    }
}
