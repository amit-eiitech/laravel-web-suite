<?php

namespace Eii\WebSuite\Filament\Resources\BlogPost;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\BlogPost\Pages\CreateBlogPost;
use Eii\WebSuite\Filament\Resources\BlogPost\Pages\EditBlogPost;
use Eii\WebSuite\Filament\Resources\BlogPost\Pages\ListBlogPosts;
use Eii\WebSuite\Filament\Resources\BlogPost\Schemas\BlogPostForm;
use Eii\WebSuite\Filament\Resources\BlogPost\Tables\BlogPostTable;
use Eii\WebSuite\Models\BlogPost;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $modelLabel = 'Blog Post';

    protected static ?string $pluralModelLabel = 'Blog Posts';

    protected static ?int $navigationSort = 3;



    public static function form(Schema $schema): Schema
    {
        return BlogPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogPostTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogPosts::route('/'),
            'create' => CreateBlogPost::route('/create'),
            'edit' => EditBlogPost::route('/{record}/edit'),
        ];
    }
}
