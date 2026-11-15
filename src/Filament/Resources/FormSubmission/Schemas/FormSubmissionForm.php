<?php

namespace Eii\WebSuite\Filament\Resources\FormSubmission\Schemas;

use Eii\WebSuite\Enums\FormSubmissionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FormSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Submission Status & Handling')
                    ->description('Status and triage information for this received message')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('form_id')
                            ->relationship('form', 'name')
                            ->disabled()
                            ->label('Form')
                            ->helperText('Form from which this message originated'),

                        Select::make('status')
                            ->options(FormSubmissionStatus::class)
                            ->default(FormSubmissionStatus::New)
                            ->required()
                            ->helperText('Update status as you process this submission'),

                        DateTimePicker::make('handled_at')
                            ->native(false)
                            ->helperText('Timestamp when an agent responded to or processed this submission'),

                        TextInput::make('ip_hash')
                            ->disabled()
                            ->label('Anonymized IP Hash')
                            ->helperText('Hashed client IP address for rate-limiting and abuse verification'),
                    ])->columns(2),

                Section::make('Submitted Payload')
                    ->columnSpanFull()
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
