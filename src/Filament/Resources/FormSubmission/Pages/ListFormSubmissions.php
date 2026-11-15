<?php

namespace Eii\WebSuite\Filament\Resources\FormSubmission\Pages;

use Eii\WebSuite\Filament\Resources\FormSubmission\FormSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormSubmissions extends ListRecords
{
    protected static string $resource = FormSubmissionResource::class;

    protected static ?string $title = 'Form Submissions';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
