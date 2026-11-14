<?php

namespace Eii\WebSuite\Filament\Resources\ContactSubmission;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\ContactSubmission\Pages\CreateContactSubmission;
use Eii\WebSuite\Filament\Resources\ContactSubmission\Pages\EditContactSubmission;
use Eii\WebSuite\Filament\Resources\ContactSubmission\Pages\ListContactSubmissions;
use Eii\WebSuite\Filament\Resources\ContactSubmission\Schemas\ContactSubmissionForm;
use Eii\WebSuite\Filament\Resources\ContactSubmission\Tables\ContactSubmissionTable;
use Eii\WebSuite\Models\ContactSubmission;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string | UnitEnum | null $navigationGroup = 'Contact';

    protected static ?string $navigationLabel = 'Submissions';

    protected static ?string $modelLabel = 'Contact Submission';

    protected static ?string $pluralModelLabel = 'Contact Submissions';

    protected static ?int $navigationSort = 1;

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
        return ContactSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactSubmissionTable::configure($table);
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
            'index' => ListContactSubmissions::route('/'),
            'create' => CreateContactSubmission::route('/create'),
            'edit' => EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
