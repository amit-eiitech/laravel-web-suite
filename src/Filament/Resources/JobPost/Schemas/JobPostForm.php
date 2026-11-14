<?php

namespace Eii\WebSuite\Filament\Resources\JobPost\Schemas;

use Eii\WebSuite\Enums\EmploymentType;
use Eii\WebSuite\Enums\JobPostStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Position Details')
                    ->description('Primary information about this job opening')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('The job title as it will appear publicly, e.g. Senior Software Engineer'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('URL-friendly identifier for the careers page (auto-generated if empty)'),

                        TextInput::make('department')
                            ->maxLength(255)
                            ->helperText('Organizational department or team, e.g. Engineering, Sales, Marketing'),

                        Select::make('employment_type')
                            ->options(EmploymentType::class)
                            ->helperText('Contract and employment arrangement'),

                        TextInput::make('location')
                            ->maxLength(255)
                            ->helperText('Workplace location or arrangement, e.g. Tokyo HQ / Hybrid / Remote'),

                        TextInput::make('salary_range')
                            ->maxLength(255)
                            ->helperText('Estimated salary or compensation range, e.g. ¥6,000,000 - ¥9,000,000'),
                    ])->columns(2),

                Section::make('Role Description & Requirements')
                    ->description('Detailed overview of responsibilities and candidate qualifications')
                    ->schema([
                        RichEditor::make('description')
                            ->columnSpanFull()
                            ->helperText('In-depth description of responsibilities, day-to-day work, and team culture'),

                        TagsInput::make('requirements')
                            ->columnSpanFull()
                            ->placeholder('Add a requirement and press Enter')
                            ->helperText('Key qualifications, skills, and prerequisites (one per tag)'),
                    ]),

                Section::make('Application & Deadlines')
                    ->description('How candidates can apply and when applications close')
                    ->schema([
                        TextInput::make('application_url')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('External application URL or dedicated ATS portal link'),

                        DateTimePicker::make('application_closes_at')
                            ->native(false)
                            ->helperText('Optional deadline after which applications will no longer be accepted'),
                    ])->columns(2),

                Section::make('Publishing & Visibility')
                    ->description('Control listing status and public visibility')
                    ->schema([
                        Select::make('status')
                            ->options(JobPostStatus::class)
                            ->default(JobPostStatus::Draft)
                            ->required()
                            ->helperText('Draft jobs are hidden from the careers page; Closed positions cannot receive applications'),

                        DateTimePicker::make('published_at')
                            ->native(false)
                            ->helperText('Publication date and time; leave empty to publish immediately upon saving as Published'),
                    ])->columns(2),
            ]);
    }
}
