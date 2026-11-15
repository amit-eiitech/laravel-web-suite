<?php

namespace Eii\WebSuite\Filament\Resources\SeoRedirect\Schemas;

use Eii\WebSuite\Enums\SeoRedirectStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SeoRedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Redirect Rule')
                    ->description('Description	Define the source path, destination target, HTTP response code, and whether this rule is active')
                    ->schema([
                        TextInput::make('source_path')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Relative inbound path to intercept, e.g. /old-services or /company/history'),

                        TextInput::make('destination_url')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Target relative path (e.g. /services) or external URL (e.g. https://partner.example.com)'),

                        Select::make('status_code')
                            ->options(SeoRedirectStatus::class)
                            ->default(SeoRedirectStatus::MovedPermanently->value)
                            ->required()
                            ->helperText('HTTP redirect response code returned to the client browser and search engine'),

                        Toggle::make('is_active')
                            ->label('Redirect Active')
                            ->default(true)
                            ->helperText('When enabled, incoming requests matching the source path will be redirected'),
                    ]),
            ]);
    }
}
