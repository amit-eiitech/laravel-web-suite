<?php

namespace Eii\WebSuite\Filament\Resources\FormSubmission;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\FormSubmission\Pages\CreateFormSubmission;
use Eii\WebSuite\Filament\Resources\FormSubmission\Pages\EditFormSubmission;
use Eii\WebSuite\Filament\Resources\FormSubmission\Pages\ListFormSubmissions;
use Eii\WebSuite\Filament\Resources\FormSubmission\Schemas\FormSubmissionForm;
use Eii\WebSuite\Filament\Resources\FormSubmission\Tables\FormSubmissionTable;
use Eii\WebSuite\Models\FormSubmission as FormSubmissionModel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmissionModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $recordTitleAttribute = 'id';

    protected static string | UnitEnum | null $navigationGroup = 'Forms';

    protected static ?string $navigationLabel = 'Submissions';

    protected static ?string $modelLabel = 'Form Submission';

    protected static ?string $pluralModelLabel = 'Form Submissions';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FormSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormSubmissionTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormSubmissions::route('/'),
            'create' => CreateFormSubmission::route('/create'),
            'edit' => EditFormSubmission::route('/{record}/edit'),
        ];
    }
}
