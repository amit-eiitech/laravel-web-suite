<?php

namespace Eii\WebSuite\Filament\Resources\ContactForm\Pages;

use Eii\WebSuite\Filament\Resources\ContactForm\ContactFormResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactForms extends ListRecords
{
    protected static string $resource = ContactFormResource::class;

    protected static ?string $title = 'Contact Forms';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
