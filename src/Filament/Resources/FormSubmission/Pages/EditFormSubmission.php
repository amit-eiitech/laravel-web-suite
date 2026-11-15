<?php

namespace Eii\WebSuite\Filament\Resources\FormSubmission\Pages;

use Eii\WebSuite\Filament\Resources\FormSubmission\FormSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFormSubmission extends EditRecord
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
