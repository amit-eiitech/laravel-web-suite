<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\CompanySettings as Settings;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class CompanySettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Company Settings';

    protected static ?string $title = 'Company Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 2;

    protected string $view = 'eii-web-suite::filament.pages.company-settings';

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'company_name' => $settings->company_name,
            'representative_name' => $settings->representative_name,
            'postal_code' => $settings->postal_code,
            'prefecture' => $settings->prefecture,
            'address' => $settings->address,
            'registration_number' => $settings->registration_number,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Information')
                    ->description('Basic details about your company')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The official name of your company'),

                        TextInput::make('representative_name')
                            ->maxLength(255)
                            ->helperText('Legal representative or contact person'),
                    ]),

                Section::make('Address')
                    ->description('Company postal address')
                    ->columns(2)
                    ->schema([
                        TextInput::make('postal_code')
                            ->maxLength(20)
                            ->helperText('Postal or ZIP code'),

                        TextInput::make('prefecture')
                            ->maxLength(255)
                            ->helperText('State, province, or prefecture'),

                        TextInput::make('address')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Full street address'),
                    ]),

                Section::make('Registration')
                    ->description('Company registration details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('registration_number')
                            ->maxLength(255)
                            ->helperText('Official company registration or tax ID number'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->company_name = $state['company_name'];
        $settings->representative_name = $state['representative_name'] ?? null;
        $settings->postal_code = $state['postal_code'] ?? null;
        $settings->prefecture = $state['prefecture'] ?? null;
        $settings->address = $state['address'] ?? null;
        $settings->registration_number = $state['registration_number'] ?? null;
        $settings->save();

        Notification::make()
            ->success()
            ->title('Company settings saved')
            ->send();
    }
}
