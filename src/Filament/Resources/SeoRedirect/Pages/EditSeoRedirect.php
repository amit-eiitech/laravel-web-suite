<?php

namespace Eii\WebSuite\Filament\Resources\SeoRedirect\Pages;

use Eii\WebSuite\Filament\Resources\SeoRedirect\SeoRedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeoRedirect extends EditRecord
{
    protected static string $resource = SeoRedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
