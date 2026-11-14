<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\SocialSettings as Settings;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class SocialSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Social Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 4;

    protected string $view = 'eii-web-suite::filament.pages.social-settings';

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'x_url' => $settings->x_url,
            'facebook_url' => $settings->facebook_url,
            'instagram_url' => $settings->instagram_url,
            'linkedin_url' => $settings->linkedin_url,
            'youtube_url' => $settings->youtube_url,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Social Media Accounts')
                    ->description('Links to your organization\'s official social profiles')
                    ->columns(2)
                    ->schema([
                        TextInput::make('x_url')
                            ->label('X (formerly Twitter)')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL to your X profile or feed'),

                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL to your Facebook page'),

                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL to your Instagram profile'),

                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255)
                            ->helperText('URL to your LinkedIn company page'),

                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('URL to your YouTube channel'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->x_url = $state['x_url'] ?? null;
        $settings->facebook_url = $state['facebook_url'] ?? null;
        $settings->instagram_url = $state['instagram_url'] ?? null;
        $settings->linkedin_url = $state['linkedin_url'] ?? null;
        $settings->youtube_url = $state['youtube_url'] ?? null;
        $settings->save();

        Notification::make()
            ->success()
            ->title('Social settings saved')
            ->send();
    }
}
