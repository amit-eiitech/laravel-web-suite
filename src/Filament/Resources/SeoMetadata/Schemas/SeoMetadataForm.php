<?php

namespace Eii\WebSuite\Filament\Resources\SeoMetadata\Schemas;

use Eii\WebSuite\Models\SeoMetadata;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SeoMetadataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Target')
                    ->description('Link SEO metadata to a route name for custom pages or to a model record for dynamic content')
                    ->schema([
                        TextInput::make('route_name')
                            ->label('Route Name')
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Named route (e.g. about-us). Set by developer; read-only here.'),

                        TextInput::make('seoable_type')
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated(false)
                            ->label('Model Class')
                            ->helperText('Set automatically from content type; read-only.'),

                        TextInput::make('seoable_id')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->label('Record ID')
                            ->helperText('Set automatically from content record; read-only.'),
                    ])->columns(3),

                Section::make('Standard Search Engine Metadata')
                    ->description('Meta tags consumed by search engine crawlers')
                    ->schema([
                        TextInput::make('title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Custom <title> tag (overrides the content headline)'),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Custom meta description snippet displayed in search result listings'),

                        TextInput::make('canonical_url')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Canonical URL pointing to the authoritative source of this content'),

                        TagsInput::make('robots')
                            ->placeholder('Add directive (e.g. noindex, nofollow, max-snippet:-1)')
                            ->columnSpanFull()
                            ->helperText('Robots crawler directives (one per tag)'),
                    ]),

                Section::make('Open Graph & Social Sharing')
                    ->description('Metadata used when sharing links across social platforms')
                    ->schema([
                        TextInput::make('og_title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Open Graph title (og:title)'),

                        Textarea::make('og_description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Open Graph description (og:description)'),

                        FileUpload::make('og_image')
                            ->image()
                            ->directory('seo')
                            ->columnSpanFull()
                            ->helperText('Social preview image (og:image) — 1200x630 px recommended'),
                    ]),
            ]);
    }
}
