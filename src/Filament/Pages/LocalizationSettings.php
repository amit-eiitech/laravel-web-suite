<?php

namespace Eii\WebSuite\Filament\Pages;

use DateTimeZone;
use Eii\WebSuite\Settings\LocalizationSettings as Settings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class LocalizationSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Localization Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 5;

    protected string $view = 'eii-web-suite::filament.pages.localization-settings';

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'default_locale' => $settings->default_locale,
            'timezone' => $settings->timezone,
            'date_format' => $settings->date_format,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Regional & Language Preferences')
                    ->description('Set default language, timezone, and date format')
                    ->columns(2)
                    ->schema([
                        Select::make('default_locale')
                            ->label('Default Locale')
                            ->options([
                                'ja' => 'Japanese (日本語 - ja)',
                                'en' => 'English (en)',
                                'zh' => 'Chinese Simplified (简体中文 - zh)',
                                'zh_TW' => 'Chinese Traditional (繁體中文 - zh_TW)',
                                'ko' => 'Korean (한국어 - ko)',
                                'es' => 'Spanish (Español - es)',
                                'fr' => 'French (Français - fr)',
                                'de' => 'German (Deutsch - de)',
                            ])
                            ->searchable()
                            ->required()
                            ->helperText('Primary language code for the website'),

                        Select::make('timezone')
                            ->label('Timezone')
                            ->options(array_combine(
                                DateTimeZone::listIdentifiers(),
                                DateTimeZone::listIdentifiers()
                            ))
                            ->searchable()
                            ->required()
                            ->helperText('Timezone used for dates and scheduling'),

                        TextInput::make('date_format')
                            ->label('Date Format')
                            ->required()
                            ->maxLength(50)
                            ->columnSpanFull()
                            ->helperText('PHP date format string (e.g. Y年m月d日, Y-m-d, F j, Y)'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->default_locale = $state['default_locale'];
        $settings->timezone = $state['timezone'];
        $settings->date_format = $state['date_format'];
        $settings->save();

        Notification::make()
            ->success()
            ->title('Localization settings saved')
            ->send();
    }
}
