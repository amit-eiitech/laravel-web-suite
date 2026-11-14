<?php

namespace Eii\WebSuite\Filament\Resources\JobPost;

use BackedEnum;
use Eii\WebSuite\Filament\Resources\JobPost\Pages\CreateJobPost;
use Eii\WebSuite\Filament\Resources\JobPost\Pages\EditJobPost;
use Eii\WebSuite\Filament\Resources\JobPost\Pages\ListJobPosts;
use Eii\WebSuite\Filament\Resources\JobPost\Schemas\JobPostForm;
use Eii\WebSuite\Filament\Resources\JobPost\Tables\JobPostTable;
use Eii\WebSuite\Models\JobPost;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JobPostResource extends Resource
{
    protected static ?string $model = JobPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | UnitEnum | null $navigationGroup = 'Recruitment';

    protected static ?string $navigationLabel = 'Job Openings';

    protected static ?string $modelLabel = 'Job Opening';

    protected static ?string $pluralModelLabel = 'Job Openings';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.recruitment', true)
            && parent::shouldRegisterNavigation();
    }

    public static function canViewAny(): bool
    {
        return config('eii-web-suite.filament_resources', true)
            && config('eii-web-suite.modules.recruitment', true)
            && parent::canViewAny();
    }

    public static function form(Schema $schema): Schema
    {
        return JobPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobPostTable::configure($table);
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
            'index' => ListJobPosts::route('/'),
            'create' => CreateJobPost::route('/create'),
            'edit' => EditJobPost::route('/{record}/edit'),
        ];
    }
}
