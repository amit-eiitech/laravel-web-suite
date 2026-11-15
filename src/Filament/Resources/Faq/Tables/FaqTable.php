<?php

namespace Eii\WebSuite\Filament\Resources\Faq\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FaqTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width('60px'),

                TextColumn::make('question')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->limit(60),

                TextColumn::make('category')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable(),

                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                SelectFilter::make('category'),
                TernaryFilter::make('is_published')
                    ->label('Published State')
                    ->placeholder('All FAQs')
                    ->trueLabel('Published Only')
                    ->falseLabel('Draft Only'),
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
