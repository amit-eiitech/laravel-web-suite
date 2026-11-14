<?php

namespace Eii\WebSuite\Filament\Resources\BlogPost\Schemas;

use Eii\WebSuite\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Content')
                    ->description('Primary details and body of the blog article')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The title/headline of the blog post'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('URL slug for this post (e.g. insights-into-tech-trends)'),

                        TextInput::make('author_name')
                            ->maxLength(255)
                            ->helperText('Name of the author or byline displayed publicly'),

                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload()
                            ->helperText('Select relevant categories for this article'),

                        Textarea::make('excerpt')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->rows(3)
                            ->helperText('Short introductory summary shown on blog list cards and social snippets'),

                        RichEditor::make('content')
                            ->columnSpanFull()
                            ->helperText('Main body content of the blog post with rich formatting'),
                    ])->columns(2),

                Section::make('Featured Media')
                    ->description('Visual assets for the blog post')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->directory('blog')
                            ->columnSpanFull()
                            ->helperText('Header or card thumbnail image for this post (16:9 recommended)'),
                    ]),

                Section::make('Publishing & Lifecycle')
                    ->description('Manage publication status and schedule')
                    ->schema([
                        Select::make('status')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Draft)
                            ->required()
                            ->helperText('Draft posts are not visible on the public blog'),

                        DateTimePicker::make('published_at')
                            ->native(false)
                            ->helperText('Publication timestamp; leave blank to publish immediately upon saving as Published'),
                    ])->columns(2),
            ]);
    }
}
