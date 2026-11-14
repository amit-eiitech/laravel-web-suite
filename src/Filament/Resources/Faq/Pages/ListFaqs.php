<?php

namespace Eii\WebSuite\Filament\Resources\Faq\Pages;

use Eii\WebSuite\Filament\Resources\Faq\FaqResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFaqs extends ListRecords
{
    protected static string $resource = FaqResource::class;

    protected static ?string $title = 'FAQs';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
