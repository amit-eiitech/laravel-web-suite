<?php

namespace Eii\WebSuite\Filament\Pages;

use DateTimeZone;
use Eii\WebSuite\Settings\CompanySettings;
use Eii\WebSuite\Settings\ContactSettings;
use Eii\WebSuite\Settings\GeneralSettings;
use Eii\WebSuite\Settings\LocalizationSettings;
use Eii\WebSuite\Settings\NotificationSettings;
use Eii\WebSuite\Settings\SeoSettings;
use Eii\WebSuite\Settings\SocialSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class Settings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Web Suite Settings';

    protected string $view = 'eii-web-suite::filament.pages.settings';

    public ?array $data = [];

    public function mount(
        GeneralSettings $general,
        CompanySettings $company,
        ContactSettings $contact,
        SocialSettings $social,
        LocalizationSettings $localization,
        SeoSettings $seo,
        NotificationSettings $notification,
    ): void {
        $this->form->fill([
            // General
            'site_name' => $general->site_name,
            'logo_path' => $general->logo_path,
            'favicon_path' => $general->favicon_path,

            // Company
            'company_name' => $company->company_name,
            'representative_name' => $company->representative_name,
            'postal_code' => $company->postal_code,
            'prefecture' => $company->prefecture,
            'address' => $company->address,
            'registration_number' => $company->registration_number,

            // Contact
            'public_email' => $contact->public_email,
            'phone' => $contact->phone,
            'business_hours' => $contact->business_hours,

            // Social
            'x_url' => $social->x_url,
            'facebook_url' => $social->facebook_url,
            'instagram_url' => $social->instagram_url,
            'linkedin_url' => $social->linkedin_url,
            'youtube_url' => $social->youtube_url,

            // Localization
            'default_locale' => $localization->default_locale,
            'timezone' => $localization->timezone,
            'date_format' => $localization->date_format,

            // SEO
            'default_title' => $seo->default_title,
            'default_description' => $seo->default_description,
            'default_og_image' => $seo->default_og_image,
            'allow_indexing' => $seo->allow_indexing,

            // Notification
            'admin_emails' => $notification->admin_emails ?? [],
            'contact_auto_reply_enabled' => $notification->contact_auto_reply_enabled ?? true,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-o-cog')
                            ->columns(1)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Official Website Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('The public name of the website'),

                                FileUpload::make('logo_path')
                                    ->label('Company Logo')
                                    ->image()
                                    ->directory('settings')
                                    ->helperText('Primary logo for header and branding'),

                                FileUpload::make('favicon_path')
                                    ->label('Company Favicon')
                                    ->image()
                                    ->directory('settings')
                                    ->helperText('Favicon icon displayed in browser tabs'),
                            ]),

                        Tab::make('Business')
                            ->icon('heroicon-o-building-office')
                            ->columns(3)
                            ->schema([
                                Fieldset::make('Company')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('company_name')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('The official name of your company'),

                                        TextInput::make('representative_name')
                                            ->maxLength(255)
                                            ->helperText('Legal representative or contact person'),

                                        TextInput::make('registration_number')
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('Official company registration or tax ID number'),
                                    ]),

                                Fieldset::make('Address')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('postal_code')
                                            ->maxLength(20)
                                            ->placeholder('125-1125')
                                            ->helperText('Postal or ZIP code'),

                                        TextInput::make('prefecture')
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('State, province, or prefecture'),

                                        TextInput::make('address')
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('Full street address'),
                                    ]),

                                Fieldset::make('Contact Info')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('public_email')
                                            ->email()
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('Public-facing email address'),

                                        TextInput::make('phone')
                                            ->tel()
                                            ->maxLength(50)
                                            ->placeholder('+81-3-1222-8587')
                                            ->helperText('Primary phone number'),

                                        TextInput::make('business_hours')
                                            ->maxLength(255)
                                            ->columnSpanFull()
                                            ->helperText('e.g. Monday to Friday, 9:00 AM - 6:00 PM'),
                                    ]),
                            ]),

                        Tab::make('Social')
                            ->icon('heroicon-o-share')
                            ->columns(1)
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
                                    ->helperText('URL to your YouTube channel'),
                            ]),

                        Tab::make('Localization')
                            ->icon('heroicon-o-language')
                            ->columns(3)
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
                                    ->helperText('PHP date format string (e.g. Y年m月d日, Y-m-d, F j, Y)'),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
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

                                Toggle::make('allow_indexing')
                                    ->label('Allow Search Engine Indexing')
                                    ->default(true)
                                    ->helperText('When enabled, allows search engines to crawl and index the site.'),
                            ]),

                        Tab::make('Notifications')
                            ->icon('heroicon-o-bell')
                            ->columns(1)
                            ->schema([
                                TagsInput::make('admin_emails')
                                    ->label('Admin Notification Emails')
                                    ->placeholder('Add an email address...')
                                    ->nestedRecursiveRules(['email'])
                                    ->columnSpanFull()
                                    ->helperText('Email addresses that receive new contact form notifications'),

                                Toggle::make('contact_auto_reply_enabled')
                                    ->label('Enable Auto-Reply Email')
                                    ->default(true)
                                    ->helperText('Send an automated confirmation receipt email to the user upon inquiry submission'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(
        GeneralSettings $general,
        CompanySettings $company,
        ContactSettings $contact,
        SocialSettings $social,
        LocalizationSettings $localization,
        SeoSettings $seo,
        NotificationSettings $notification,
    ): void {
        $state = $this->form->getState();

        // General
        $general->site_name = $state['site_name'];
        $general->logo_path = $state['logo_path'] ?? null;
        $general->favicon_path = $state['favicon_path'] ?? null;
        $general->save();

        // Company
        $company->company_name = $state['company_name'];
        $company->representative_name = $state['representative_name'] ?? null;
        $company->postal_code = $state['postal_code'] ?? null;
        $company->prefecture = $state['prefecture'] ?? null;
        $company->address = $state['address'] ?? null;
        $company->registration_number = $state['registration_number'] ?? null;
        $company->save();

        // Contact
        $contact->public_email = $state['public_email'] ?? null;
        $contact->phone = $state['phone'] ?? null;
        $contact->business_hours = $state['business_hours'] ?? null;
        $contact->save();

        // Social
        $social->x_url = $state['x_url'] ?? null;
        $social->facebook_url = $state['facebook_url'] ?? null;
        $social->instagram_url = $state['instagram_url'] ?? null;
        $social->linkedin_url = $state['linkedin_url'] ?? null;
        $social->youtube_url = $state['youtube_url'] ?? null;
        $social->save();

        // Localization
        $localization->default_locale = $state['default_locale'];
        $localization->timezone = $state['timezone'];
        $localization->date_format = $state['date_format'];
        $localization->save();

        // SEO
        $seo->default_title = $state['default_title'] ?? null;
        $seo->default_description = $state['default_description'] ?? null;
        $seo->default_og_image = $state['default_og_image'] ?? null;
        $seo->allow_indexing = (bool) ($state['allow_indexing'] ?? true);
        $seo->save();

        // Notification
        $notification->admin_emails = array_values(array_filter(array_map('trim', $state['admin_emails'] ?? [])));
        $notification->contact_auto_reply_enabled = (bool) ($state['contact_auto_reply_enabled'] ?? false);
        $notification->save();

        Notification::make()
            ->success()
            ->title('All settings saved')
            ->send();
    }
}
