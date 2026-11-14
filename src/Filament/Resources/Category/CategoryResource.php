<?php

namespace Eii\WebSuite\Filament\Resources\Category;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\Category\Pages\CreateCategory;
use Eii\WebSuite\Filament\Resources\Category\Pages\EditCategory;
use Eii\WebSuite\Filament\Resources\Category\Pages\ListCategories;
use Eii\WebSuite\Filament\Resources\Category\Schemas\CategoryForm;
use Eii\WebSuite\Filament\Resources\Category\Tables\CategoryTable;
use Eii\WebSuite\Models\Category;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $modelLabel = 'Category';

    protected static ?string $pluralModelLabel = 'Categories';

    protected static ?int $navigationSort = 5;



    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoryTable::configure($table);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
