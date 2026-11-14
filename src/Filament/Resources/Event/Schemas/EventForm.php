<?php

namespace Eii\WebSuite\Filament\Resources\Event\Schemas;

use Eii\WebSuite\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event Details')
                    ->description('Basic information about the event')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The display title of the event'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('URL-friendly identifier (auto-generated if empty)'),

                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->helperText('Assign one or more categories to this event'),

                        Textarea::make('excerpt')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->rows(3)
                            ->helperText('Brief summary for listings and previews'),

                        RichEditor::make('content')
                            ->columnSpanFull()
                            ->helperText('Full event description and details'),
                    ])->columns(2),

                Section::make('Event Schedule')
                    ->description('When and where the event takes place')
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->required()
                            ->native(false)
                            ->helperText('Start date and time'),

                        DateTimePicker::make('ends_at')
                            ->native(false)
                            ->after('starts_at')
                            ->helperText('End date and time'),

                        TextInput::make('location')
                            ->maxLength(255)
                            ->helperText('Event venue or location'),

                        TextInput::make('registration_url')
                            ->maxLength(255)
                            ->url()
                            ->columnSpanFull()
                            ->helperText('External registration link'),
                    ])->columns(2),

                Section::make('Media & Publishing')
                    ->description('Featured image and publication settings')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->directory('events')
                            ->columnSpanFull()
                            ->helperText('Main image for the event'),

                        Select::make('status')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Draft)
                            ->required()
                            ->helperText('Publication status'),

                        DateTimePicker::make('published_at')
                            ->native(false)
                            ->helperText('Schedule publication for a future date'),
                    ])->columns(2),
            ]);
    }
}
