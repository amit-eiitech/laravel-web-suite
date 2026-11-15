<?php

namespace Eii\WebSuite\Filament\Resources\Form\Pages;

use Eii\WebSuite\Filament\Resources\Form\FormResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected static ?string $title = 'Forms';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
