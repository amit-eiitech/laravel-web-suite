<?php

namespace Eii\WebSuite\Filament\Resources\SeoRedirect;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\SeoRedirect\Pages\CreateSeoRedirect;
use Eii\WebSuite\Filament\Resources\SeoRedirect\Pages\EditSeoRedirect;
use Eii\WebSuite\Filament\Resources\SeoRedirect\Pages\ListSeoRedirects;
use Eii\WebSuite\Filament\Resources\SeoRedirect\Schemas\SeoRedirectForm;
use Eii\WebSuite\Filament\Resources\SeoRedirect\Tables\SeoRedirectTable;
use Eii\WebSuite\Models\SeoRedirect;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SeoRedirectResource extends Resource
{
    protected static ?string $model = SeoRedirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowRightOnRectangle;

    protected static ?string $recordTitleAttribute = 'source_path';

    protected static string | UnitEnum | null $navigationGroup = 'SEO';

    protected static ?string $navigationLabel = 'Redirects';

    protected static ?string $modelLabel = 'SEO Redirect';

    protected static ?string $pluralModelLabel = 'SEO Redirects';

    protected static ?int $navigationSort = 2;

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
        return SeoRedirectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeoRedirectTable::configure($table);
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
            'index' => ListSeoRedirects::route('/'),
            'create' => CreateSeoRedirect::route('/create'),
            'edit' => EditSeoRedirect::route('/{record}/edit'),
        ];
    }
}
