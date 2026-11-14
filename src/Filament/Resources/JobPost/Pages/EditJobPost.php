<?php

namespace Eii\WebSuite\Filament\Resources\JobPost\Pages;

use Eii\WebSuite\Filament\Resources\JobPost\JobPostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobPost extends EditRecord
{
    protected static string $resource = JobPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
