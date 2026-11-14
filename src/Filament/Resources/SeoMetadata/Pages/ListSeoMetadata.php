<?php

namespace Eii\WebSuite\Filament\Resources\SeoMetadata\Pages;

use Eii\WebSuite\Filament\Resources\SeoMetadata\SeoMetadataResource;
use Filament\Resources\Pages\ListRecords;

class ListSeoMetadata extends ListRecords
{
    protected static string $resource = SeoMetadataResource::class;

    protected static ?string $title = 'SEO Metadata';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
