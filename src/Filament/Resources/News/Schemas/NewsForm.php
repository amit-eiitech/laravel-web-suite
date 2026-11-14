<?php

namespace Eii\WebSuite\Filament\Resources\News\Schemas;

use Eii\WebSuite\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article Details')
                    ->description('Basic information about the news article')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The headline of the news article'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('URL-friendly identifier (auto-generated from title if empty)'),

                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->helperText('Assign one or more categories to this news article'),

                        Textarea::make('excerpt')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->rows(3)
                            ->helperText('Brief summary shown in listings and social shares'),

                        RichEditor::make('content')
                            ->columnSpanFull()
                            ->helperText('Full article content with rich text formatting'),
                    ])->columns(2),

                Section::make('Media')
                    ->description('Featured image for the article')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->directory('news')
                            ->columnSpanFull()
                            ->helperText('Main image displayed with the article'),
                    ]),

                Section::make('Publishing')
                    ->description('Control when and how this article is published')
                    ->schema([
                        Select::make('status')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Draft)
                            ->required()
                            ->helperText('Draft articles are not visible to the public'),

                        DateTimePicker::make('published_at')
                            ->native(false)
                            ->helperText('Leave empty to publish immediately when status is "Published", or schedule for later'),
                    ])->columns(2),
            ]);
    }
}
