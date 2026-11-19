<?php

namespace Eii\WebSuite\Filament\Resources\JobPost\Tables;

use Eii\WebSuite\Enums\EmploymentType;
use Eii\WebSuite\Enums\JobPostStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class JobPostTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),

                TextColumn::make('department')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('employment_type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('location')
                    ->searchable()
                    ->limit(25),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('application_closes_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Deadline')
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
                    ->options(JobPostStatus::class),
                SelectFilter::make('employment_type')
                    ->options(EmploymentType::class),
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
