<?php

namespace Eii\WebSuite\Filament\Resources\SeoRedirect\Pages;

use Eii\WebSuite\Filament\Resources\SeoRedirect\SeoRedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeoRedirects extends ListRecords
{
    protected static string $resource = SeoRedirectResource::class;

    protected static ?string $title = 'SEO Redirects';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
