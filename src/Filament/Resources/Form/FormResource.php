<?php

namespace Eii\WebSuite\Filament\Resources\Form;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\Form\Pages\CreateForm;
use Eii\WebSuite\Filament\Resources\Form\Pages\EditForm;
use Eii\WebSuite\Filament\Resources\Form\Pages\ListForms;
use Eii\WebSuite\Filament\Resources\Form\Schemas\FormForm;
use Eii\WebSuite\Filament\Resources\Form\Tables\FormTable;
use Eii\WebSuite\Models\Form as FormModel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Forms';

    protected static ?string $navigationLabel = 'Forms';

    protected static ?string $modelLabel = 'Form';

    protected static ?string $pluralModelLabel = 'Forms';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return FormForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
        ];
    }
}
