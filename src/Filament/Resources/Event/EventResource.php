<?php

namespace Eii\WebSuite\Filament\Resources\Event;

use Eii\WebSuite\Filament\Resources\Event\Pages\CreateEvent;
use Eii\WebSuite\Filament\Resources\Event\Pages\EditEvent;
use Eii\WebSuite\Filament\Resources\Event\Pages\ListEvents;
use Eii\WebSuite\Filament\Resources\Event\Schemas\EventForm;
use Eii\WebSuite\Filament\Resources\Event\Tables\EventTable;
use Eii\WebSuite\Models\Event;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Events';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.events', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canViewAny(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.events', true)
            && parent::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        return EventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
