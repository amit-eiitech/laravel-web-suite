<?php

namespace Eii\WebSuite\Filament\Pages;

use Eii\WebSuite\Settings\SeoSettings as Settings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class SeoSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'SEO Settings';

    protected static ?string $title = 'Contact Settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected static ?int $navigationSort = 6;

    protected string $view = 'eii-web-suite::filament.pages.seo-settings';

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.seo', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canAccess(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.seo', true)
            && parent::canAccess();
    }

    public ?array $data = [];

    public function mount(Settings $settings): void
    {
        $this->form->fill([
            'default_title' => $settings->default_title,
            'default_description' => $settings->default_description,
            'default_og_image' => $settings->default_og_image,
            'allow_indexing' => $settings->allow_indexing,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Search Engine Metadata')
                    ->description('Fallback meta tags for pages without explicit SEO metadata')
                    ->columns(2)
                    ->schema([
                        TextInput::make('default_title')
                            ->label('Default Meta Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Fallback title used in search engine results and social previews'),

                        Textarea::make('default_description')
                            ->label('Default Meta Description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Fallback snippet shown beneath the title in search results'),

                        FileUpload::make('default_og_image')
                            ->label('Default Social Image (OG Image)')
                            ->image()
                            ->directory('seo')
                            ->columnSpanFull()
                            ->helperText('Default preview image shared on social networks (recommended: 1200x630 px)'),
                    ]),

                Section::make('Crawling & Indexing')
                    ->description('Search engine crawler visibility')
                    ->columns(1)
                    ->schema([
                        Toggle::make('allow_indexing')
                            ->label('Allow Search Engine Indexing')
                            ->default(true)
                            ->helperText('When enabled, allows search engines to crawl and index the site. Disable to emit noindex, nofollow directives.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(Settings $settings): void
    {
        $state = $this->form->getState();

        $settings->default_title = $state['default_title'] ?? null;
        $settings->default_description = $state['default_description'] ?? null;
        $settings->default_og_image = $state['default_og_image'] ?? null;
        $settings->allow_indexing = (bool) ($state['allow_indexing'] ?? true);
        $settings->save();

        Notification::make()
            ->success()
            ->title('SEO settings saved')
            ->send();
    }
}
