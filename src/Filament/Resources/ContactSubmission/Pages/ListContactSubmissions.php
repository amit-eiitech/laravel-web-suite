<?php

namespace Eii\WebSuite\Filament\Resources\ContactSubmission\Pages;

use Eii\WebSuite\Filament\Resources\ContactSubmission\ContactSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContactSubmissions extends ListRecords
{
    protected static string $resource = ContactSubmissionResource::class;

    protected static ?string $title = 'Contact Submissions';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
