<?php

namespace Eii\WebSuite\Filament\Resources\Event\Pages;

use Eii\WebSuite\Filament\Resources\Event\EventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected static ?string $title = 'Events';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
