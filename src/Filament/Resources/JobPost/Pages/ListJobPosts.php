<?php

namespace Eii\WebSuite\Filament\Resources\JobPost\Pages;

use Eii\WebSuite\Filament\Resources\JobPost\JobPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobPosts extends ListRecords
{
    protected static string $resource = JobPostResource::class;

    protected static ?string $title = 'Job Openings';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
