<?php

namespace Eii\WebSuite\Filament\Resources\Faq\Pages;

use Eii\WebSuite\Filament\Resources\Faq\FaqResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
