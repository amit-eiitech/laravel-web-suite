<?php

namespace Eii\WebSuite\Filament\Resources\ContactSubmission\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inquiry Status & Handling')
                    ->description('Status and triage information for this received message')
                    ->schema([
                        Select::make('contact_form_id')
                            ->relationship('form', 'name')
                            ->disabled()
                            ->label('Contact Form')
                            ->helperText('Form from which this message originated'),

                        Select::make('status')
                            ->options([
                                'new' => 'New',
                                'read' => 'Read',
                                'replied' => 'Replied',
                                'archived' => 'Archived',
                            ])
                            ->default('new')
                            ->required()
                            ->helperText('Update status as you process this customer inquiry'),

                        DateTimePicker::make('handled_at')
                            ->native(false)
                            ->helperText('Timestamp when an agent responded to or processed this submission'),

                        TextInput::make('ip_hash')
                            ->disabled()
                            ->label('Anonymized IP Hash')
                            ->helperText('Hashed client IP address for rate-limiting and abuse verification'),
                    ])->columns(2),

                Section::make('Submitted Payload')
                    ->description('User-submitted form fields and responses')
                    ->schema([
                        KeyValue::make('data')
                            ->label('Form Values')
                            ->keyLabel('Field Name')
                            ->valueLabel('Submitted Value')
                            ->columnSpanFull()
                            ->helperText('All values provided by the visitor upon form submission'),
                    ]),
            ]);
    }
}
