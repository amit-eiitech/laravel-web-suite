<?php

namespace Eii\WebSuite\Filament\Resources\ContactForm;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\ContactForm\Pages\CreateContactForm;
use Eii\WebSuite\Filament\Resources\ContactForm\Pages\EditContactForm;
use Eii\WebSuite\Filament\Resources\ContactForm\Pages\ListContactForms;
use Eii\WebSuite\Filament\Resources\ContactForm\Schemas\ContactFormForm;
use Eii\WebSuite\Filament\Resources\ContactForm\Tables\ContactFormTable;
use Eii\WebSuite\Models\ContactForm;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContactFormResource extends Resource
{
    protected static ?string $model = ContactForm::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Contact';

    protected static ?string $navigationLabel = 'Forms';

    protected static ?string $modelLabel = 'Contact Form';

    protected static ?string $pluralModelLabel = 'Contact Forms';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.contact', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canViewAny(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.contact', true)
            && parent::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        return ContactFormForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactFormTable::configure($table);
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
            'index' => ListContactForms::route('/'),
            'create' => CreateContactForm::route('/create'),
            'edit' => EditContactForm::route('/{record}/edit'),
        ];
    }
}
