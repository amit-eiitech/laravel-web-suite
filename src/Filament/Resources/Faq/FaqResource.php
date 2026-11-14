<?php

namespace Eii\WebSuite\Filament\Resources\Faq;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\Faq\Pages\CreateFaq;
use Eii\WebSuite\Filament\Resources\Faq\Pages\EditFaq;
use Eii\WebSuite\Filament\Resources\Faq\Pages\ListFaqs;
use Eii\WebSuite\Filament\Resources\Faq\Schemas\FaqForm;
use Eii\WebSuite\Filament\Resources\Faq\Tables\FaqTable;
use Eii\WebSuite\Models\Faq;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $recordTitleAttribute = 'question';

    protected static string | UnitEnum | null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'FAQs';

    protected static ?string $modelLabel = 'FAQ';

    protected static ?string $pluralModelLabel = 'FAQs';

    protected static ?int $navigationSort = 4;



    public static function form(Schema $schema): Schema
    {
        return FaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FaqTable::configure($table);
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
            'index' => ListFaqs::route('/'),
            'create' => CreateFaq::route('/create'),
            'edit' => EditFaq::route('/{record}/edit'),
        ];
    }
}
