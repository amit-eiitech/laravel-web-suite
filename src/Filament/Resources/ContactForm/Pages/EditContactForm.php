<?php

namespace Eii\WebSuite\Filament\Resources\ContactForm\Pages;

use Eii\WebSuite\Filament\Resources\ContactForm\ContactFormResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactForm extends EditRecord
{
    protected static string $resource = ContactFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
