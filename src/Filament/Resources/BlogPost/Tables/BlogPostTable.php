<?php

namespace Eii\WebSuite\Filament\Resources\BlogPost\Tables;

use Eii\WebSuite\Enums\ContentStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogPostTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->circular()
                    ->label('Image'),

                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->limit(45),

                TextColumn::make('author_name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('categories.name')
                    ->badge()
                    ->color('info')
                    ->label('Categories'),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Published'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(ContentStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions(config('eii-web-suite.filament.show_bulk_actions', true)
                ? [
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ]
                : []);
    }
}
