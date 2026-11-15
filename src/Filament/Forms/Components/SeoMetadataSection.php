<?php

namespace Eii\WebSuite\Filament\Forms\Components;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;

class SeoMetadataSection
{
    /**
     * Create a reusable form container pre-configured for the 1-to-1 seoMetadata relationship.
     */
    public static function make(
        string $relationship = 'seoMetadata',
        int|array $columns = 1,
    ): Grid {
        return Grid::make($columns)
            ->relationship($relationship)
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->helperText('Custom title tag (<title>). Overrides the default headline in search results.'),

                        Textarea::make('description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Snippet displayed under the title in search listings (approx. 150–160 characters recommended).'),

                        TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Preferred canonical URL if this content is syndicated or accessible via multiple paths.'),

                        TagsInput::make('robots')
                            ->label('Robots Directives')
                            ->placeholder('e.g. noindex, nofollow, max-snippet:-1')
                            ->helperText('Crawler indexing instructions (press Enter after each directive).'),
                    ]),

                Group::make()
                    ->schema([
                        TextInput::make('og_title')
                            ->label('Social Share Title (og:title)')
                            ->maxLength(255)
                            ->helperText('Headline used when this content is shared on Facebook, LinkedIn, X, etc.'),

                        Textarea::make('og_description')
                            ->label('Social Share Description (og:description)')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Summary snippet used in social media preview cards.'),

                        FileUpload::make('og_image')
                            ->label('Social Share Image (og:image)')
                            ->image()
                            ->directory('seo')
                            ->helperText('Thumbnail image for social media sharing cards (1200x630 px recommended).'),
                    ]),
            ]);
    }
}
