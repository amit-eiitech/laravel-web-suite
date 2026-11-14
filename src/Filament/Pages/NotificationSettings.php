<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\NotificationSettings as Settings;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class NotificationSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Notification Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 7;

    protected string $view = 'eii-web-suite::filament.pages.notification-settings';

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'admin_emails' => $settings->admin_emails ?? [],
            'contact_auto_reply_enabled' => $settings->contact_auto_reply_enabled ?? true,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admin Email Alerts')
                    ->description('Email addresses notified upon receiving form submissions and inquiries')
                    ->columns(1)
                    ->schema([
                        TagsInput::make('admin_emails')
                            ->label('Admin Notification Emails')
                            ->placeholder('Add an email address...')
                            ->nestedRecursiveRules(['email'])
                            ->columnSpanFull()
                            ->helperText('Enter email addresses that should receive new contact form notifications'),
                    ]),

                Section::make('Customer Auto-Reply')
                    ->description('Automated response sent to users after submitting forms')
                    ->columns(1)
                    ->schema([
                        Toggle::make('contact_auto_reply_enabled')
                            ->label('Enable Auto-Reply Email')
                            ->default(true)
                            ->helperText('Send an automated confirmation receipt email to the user upon inquiry submission'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->admin_emails = array_values(array_filter(array_map('trim', $state['admin_emails'] ?? [])));
        $settings->contact_auto_reply_enabled = (bool) ($state['contact_auto_reply_enabled'] ?? false);
        $settings->save();

        Notification::make()
            ->success()
            ->title('Notification settings saved')
            ->send();
    }
}
