<?php

namespace Eii\WebSuite\Filament\Resources\SeoMetadata\Pages;

use Eii\WebSuite\Filament\Resources\SeoMetadata\SeoMetadataResource;
use Filament\Resources\Pages\EditRecord;

class EditSeoMetadata extends EditRecord
{
    protected static string $resource = SeoMetadataResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
