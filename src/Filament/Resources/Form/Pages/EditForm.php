<?php

namespace Eii\WebSuite\Filament\Resources\Form\Pages;

use Eii\WebSuite\Filament\Resources\Form\FormResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
