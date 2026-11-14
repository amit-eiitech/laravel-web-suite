<?php

namespace Eii\WebSuite\Filament\Resources\News;

use Eii\WebSuite\Filament\Resources\News\Pages\CreateNews;
use Eii\WebSuite\Filament\Resources\News\Pages\EditNews;
use Eii\WebSuite\Filament\Resources\News\Pages\ListNews;
use Eii\WebSuite\Filament\Resources\News\Schemas\NewsForm;
use Eii\WebSuite\Filament\Resources\News\Tables\NewsTable;
use Eii\WebSuite\Models\News;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'News';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.news', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canViewAny(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.news', true)
            && parent::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        return NewsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsTable::configure($table);
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
            'index' => ListNews::route('/'),
            'create' => CreateNews::route('/create'),
            'edit' => EditNews::route('/{record}/edit'),
        ];
    }
}
