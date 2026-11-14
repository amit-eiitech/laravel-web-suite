<?php

namespace Eii\WebSuite\Filament\Resources\SeoRedirect\Tables;

use Eii\WebSuite\Enums\SeoRedirectStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SeoRedirectTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source_path')
                    ->label('Source')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('destination_url')
                    ->label('Destination')
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('status_code')
                    ->badge()
                    ->formatStateUsing(fn(SeoRedirectStatus $state): string => $state->getShortLabel())
                    ->sortable()
                    ->label('HTTP Code'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
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
            ->defaultSort('source_path', 'asc')
            ->filters([
                SelectFilter::make('status_code')
                    ->options([
                        301 => '301 Moved Permanently',
                        302 => '302 Found',
                        307 => '307 Temporary Redirect',
                        308 => '308 Permanent Redirect',
                        410 => '410 Gone',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active State')
                    ->placeholder('All Redirects')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
