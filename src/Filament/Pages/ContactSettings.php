<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\ContactSettings as Settings;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class ContactSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Contact Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 3;

    protected string $view = 'eii-web-suite::filament.pages.contact-settings';

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.contact', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canAccess(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.contact', true)
            && parent::canAccess();
    }

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'public_email' => $settings->public_email,
            'phone' => $settings->phone,
            'business_hours' => $settings->business_hours,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->description('Public contact details for your customers')
                    ->columns(2)
                    ->schema([
                        TextInput::make('public_email')
                            ->email()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Public-facing email address'),

                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(50)
                            ->helperText('Primary phone number'),
                    ]),

                Section::make('Business Hours')
                    ->description('When customers can reach you')
                    ->columns(1)
                    ->schema([
                        TextInput::make('business_hours')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('e.g. Monday to Friday, 9:00 AM - 6:00 PM'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->public_email = $state['public_email'] ?? null;
        $settings->phone = $state['phone'] ?? null;
        $settings->business_hours = $state['business_hours'] ?? null;
        $settings->save();

        Notification::make()
            ->success()
            ->title('Contact settings saved')
            ->send();
    }
}
