<?php

namespace Eii\WebSuite\Filament\Resources\SeoMetadata;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\SeoMetadata\Pages\EditSeoMetadata;
use Eii\WebSuite\Filament\Resources\SeoMetadata\Pages\ListSeoMetadata;
use Eii\WebSuite\Filament\Resources\SeoMetadata\Schemas\SeoMetadataForm;
use Eii\WebSuite\Filament\Resources\SeoMetadata\Tables\SeoMetadataTable;
use Eii\WebSuite\Models\SeoMetadata;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SeoMetadataResource extends Resource
{
    protected static ?string $model = SeoMetadata::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'SEO';

    protected static ?string $navigationLabel = 'Metadata';

    protected static ?string $modelLabel = 'SEO Metadata';

    protected static ?string $pluralModelLabel = 'SEO Metadata';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.seo', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canViewAny(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.seo', true)
            && parent::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        return SeoMetadataForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoMetadataTable::configure($table);
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
            'index' => ListSeoMetadata::route('/'),
            'edit' => EditSeoMetadata::route('/{record}/edit'),
        ];
    }
}
