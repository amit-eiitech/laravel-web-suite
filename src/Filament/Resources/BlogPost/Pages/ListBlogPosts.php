<?php

namespace Eii\WebSuite\Filament\Resources\BlogPost\Pages;

use Eii\WebSuite\Filament\Resources\BlogPost\BlogPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogPosts extends ListRecords
{
    protected static string $resource = BlogPostResource::class;

    protected static ?string $title = 'Blog Posts';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
