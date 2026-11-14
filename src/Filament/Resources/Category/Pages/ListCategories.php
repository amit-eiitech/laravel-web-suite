<?php

namespace Eii\WebSuite\Filament\Resources\Category\Pages;

use Eii\WebSuite\Filament\Resources\Category\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected static ?string $title = 'Categories';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
