<?php

namespace Eii\WebSuite\Filament\Resources\Form\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Form Configuration')
                    ->description('General identification and status for this form')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $set, $state, callable $get) {
                                if (! filled($get('slug'))) {
                                    $set('slug', self::slugify($state));
                                }
                            })
                            ->helperText('Human-readable name, e.g. Feedback, Quote Request, Event Registration'),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Unique slug used in frontend form components and embed routes'),

                        Toggle::make('is_active')
                            ->label('Accepting Submissions')
                            ->default(true)
                            ->helperText('When enabled, submissions to this form are processed and recorded'),
                    ]),

                Section::make('Form Fields')
                    ->description('Define field handles and their expected input types')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('fields')
                            ->label('Form Fields')
                            ->columnSpanFull()
                            ->columns(2)
                            ->addActionLabel('Add field')
                            ->schema([
                                TextInput::make('key')
                                    ->label('Field handle (used in submissions)')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('email, company, message')
                                    ->helperText('This becomes the input name and the key in stored submissions'),

                                Select::make('type')
                                    ->label('Input Type / Validation')
                                    ->required()
                                    ->options([
                                        'text' => 'Text',
                                        'email' => 'Email',
                                        'tel' => 'Phone',
                                        'textarea' => 'Textarea',
                                        'select' => 'Select',
                                        'radio' => 'Radio',
                                        'checkbox' => 'Checkbox',
                                        'number' => 'Number',
                                        'url' => 'URL',
                                    ])
                                    ->searchable()
                                    ->helperText('Pick the expected input so you do not mistype values'),
                            ])
                            ->afterStateHydrated(function (callable $set, $state): void {
                                $items = collect($state ?? []);

                                if ($items->isEmpty()) {
                                    $set('fields', []);
                                    return;
                                }

                                $isOldKeyValueShape = $items->every(
                                    fn($value, $key) => is_string($key) && ! is_array($value)
                                );

                                if ($isOldKeyValueShape) {
                                    $items = $items->map(
                                        fn($value, $key) => ['key' => $key, 'type' => $value]
                                    );
                                }

                                $set('fields', $items->values()->toArray());
                            })
                            ->mutateDehydratedStateUsing(function (array $state): array {
                                return collect($state)
                                    ->filter(fn($item) => filled($item['key'] ?? null) && filled($item['type'] ?? null))
                                    ->mapWithKeys(fn($item) => [$item['key'] => $item['type']])
                                    ->toArray();
                            })
                            ->helperText('Custom fields configured for this form definition'),
                    ]),

                Section::make('Custom Form Settings')
                    ->description('Behavioral options like recipient overrides, webhook URLs, or auto-reply templates')
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        KeyValue::make('settings')
                            ->keyLabel('Setting Key')
                            ->valueLabel('Value')
                            ->columnSpanFull()
                            ->helperText('Optional parameters, e.g. notification_email, success_redirect_url, turnstile_enabled'),
                    ]),
            ]);
    }

    protected static function slugify(string $value): string
    {
        $ascii = Str::of($value)->ascii('ja');
        $slug = Str::slug($ascii);

        return $slug ?: Str::slug($value);
    }
}
