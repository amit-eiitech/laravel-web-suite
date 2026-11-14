<?php

namespace Eii\WebSuite\Filament\Resources\BlogPost\Pages;

use Eii\WebSuite\Filament\Resources\BlogPost\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;
}
