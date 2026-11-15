<?php

namespace Eii\WebSuite\Filament\Resources\Category\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->description('Categorization taxonomies shared across content types')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Public category name, e.g. Corporate News, Product Launch, Company Events'),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->helperText('URL slug for this category archive page'),

                        Select::make('scope')
                            ->options([
                                'news' => 'News',
                                'events' => 'Events',
                                'blog' => 'Blog',
                            ])
                            ->default('news')
                            ->required()
                            ->helperText('The content module this taxonomy applies to'),

                        Textarea::make('description')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull()
                            ->helperText('Optional description displayed on the category archive page or in meta descriptions'),
                    ]),
            ]);
    }
}
