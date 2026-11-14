<?php

namespace Eii\WebSuite\Filament\Resources\News\Pages;

use Eii\WebSuite\Filament\Resources\News\NewsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;

    protected static ?string $title = 'News';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
