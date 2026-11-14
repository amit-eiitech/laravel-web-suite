<?php

namespace Eii\WebSuite\Filament\Resources\ContactForm\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactFormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form Configuration')
                    ->description('General identification and status for this contact form')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Human-readable name, e.g. General Inquiries, Project Quote Request'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Unique slug used in frontend form components and embed routes'),

                        Toggle::make('is_active')
                            ->label('Accepting Submissions')
                            ->default(true)
                            ->helperText('When enabled, submissions to this form are processed and recorded'),
                    ])->columns(3),

                Section::make('Form Fields')
                    ->description('Define form field keys and their expected input types')
                    ->schema([
                        KeyValue::make('fields')
                            ->keyLabel('Field Key (e.g. email, message, company)')
                            ->valueLabel('Input Type / Validation (e.g. text, email, tel, textarea)')
                            ->columnSpanFull()
                            ->helperText('Custom fields configured for this form definition'),
                    ]),

                Section::make('Custom Form Settings')
                    ->description('Behavioral options like recipient overrides, webhook URLs, or auto-reply templates')
                    ->schema([
                        KeyValue::make('settings')
                            ->keyLabel('Setting Key')
                            ->valueLabel('Value')
                            ->columnSpanFull()
                            ->helperText('Optional parameters, e.g. notification_email, success_redirect_url, turnstile_enabled'),
                    ]),
            ]);
    }
}
