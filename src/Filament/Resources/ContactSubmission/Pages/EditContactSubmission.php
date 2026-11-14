<?php

namespace Eii\WebSuite\Filament\Resources\ContactSubmission\Pages;

use Eii\WebSuite\Filament\Resources\ContactSubmission\ContactSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContactSubmission extends EditRecord
{
    protected static string $resource = ContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
