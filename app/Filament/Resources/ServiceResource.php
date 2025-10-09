<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 11; // directly below Hero Slides
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $locales = ['en' => 'English', 'ka' => 'ქართული'];

        return $form->schema([
            Forms\Components\Grid::make(12)->schema([
                Forms\Components\Section::make('Content')
                    ->columnSpan(8)
                    ->schema([
                        Forms\Components\Tabs::make('i18n')
                            ->persistTabInQueryString()
                            ->tabs(
                                collect($locales)->map(function ($label, $code) {
                                    return Forms\Components\Tabs\Tab::make($label)
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            Forms\Components\TextInput::make("name.$code")
                                                ->label('Title')
                                                ->required()
                                                ->maxLength(160),
                                            Forms\Components\Textarea::make("description.$code")
                                                ->label('Description')
                                                ->rows(4)
                                                ->required(),
                                            Forms\Components\Repeater::make("problems.$code")
                                                ->label('Problems')
                                                ->schema([
                                                    Forms\Components\TextInput::make('value')
                                                        ->label('Problem')
                                                        ->required()
                                                        ->maxLength(240),
                                                ])
                                                ->addActionLabel('Add problem')
                                                ->columns(1)
                                                ->collapsed()
                                                ->default([]),
                                        ]);
                                })->toArray()
                            ),
                    ]),

                Forms\Components\Section::make('Meta')
                    ->columnSpan(4)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(120),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Card Image')
                            ->directory('services')
                            ->image()
                            ->imageEditor()
                            ->downloadable()
                            ->visibility('public')
                            ->required()
                            ->helperText('Use a 16:10 image (about 1280×800) so the homepage cards stay crisp.'),

                        Forms\Components\TextInput::make('image_alt')
                            ->label('Image alt')
                            ->maxLength(160)
                            ->helperText('If empty, falls back to English title.'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Feature on homepage')
                            ->live(),

                        Forms\Components\TextInput::make('featured_order')
                            ->label('Homepage order (1–3)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(3)
                            ->default(0)
                            ->visible(fn (Get $get) => (bool) $get('is_featured'))
                            ->helperText('Used only when featured.'),

                        Forms\Components\TextInput::make('display_order')
                            ->label('Services page order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Lower numbers appear first on the services page.'),

                        Forms\Components\Select::make('cue_style')
                            ->label('Cue style')
                            ->options([
                                'bubbles' => 'Bubbles',
                                'bars'    => 'Bars',
                                'dots'    => 'Dots',
                            ])
                            ->default('bubbles')
                            ->required(),

                        Forms\Components\Fieldset::make('Cue label')
                            ->schema([
                                Forms\Components\TextInput::make('cue_label.en')
                                    ->label('Cue label (EN)')
                                    ->maxLength(120),
                                Forms\Components\TextInput::make('cue_label.ka')
                                    ->label('Cue label (KA)')
                                    ->maxLength(120),
                            ]),

                        Forms\Components\Repeater::make('cue_values')
                            ->label('Cue values')
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->label('Value')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->required(),
                            ])
                            ->addActionLabel('Add value')
                            ->columns(1)
                            ->default([])
                            ->helperText('For dots, use 1 for on and 0 for off.'),
                    ]),

            ]),
        ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        $locale = App::getLocale();

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->square()
                    ->height(48),

                Tables\Columns\TextColumn::make("name->$locale")
                    ->label('Title')
                    ->limit(40)
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search) use ($locale) {
                        $query->where("name->$locale", 'like', "%{$search}%")
                              ->orWhere('slug', 'like', "%{$search}%");
                    }),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('featured_order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('display_order')
                    ->label('Services order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->label('Updated'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('display_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }

    // Helper for page hooks (Create/Edit) to normalize repeater payload to plain arrays.
    public static function normalizeProblems(array $data, array $locales): array
    {
        if (! isset($data['problems'])) {
            return $data;
        }

        foreach ($locales as $code => $_) {
            if (isset($data['problems'][$code]) && is_array($data['problems'][$code])) {
                $data['problems'][$code] = collect($data['problems'][$code])
                    ->map(fn ($row) => is_array($row) ? ($row['value'] ?? '') : (string) $row)
                    ->filter()
                    ->values()
                    ->all();
            }
        }

        return $data;
    }

    // Prepare persisted plain strings for the repeater field expectations.
    public static function expandProblemsForForm(array $data, array $locales): array
    {
        if (! isset($data['problems'])) {
            return $data;
        }

        foreach ($locales as $code => $_) {
            if (isset($data['problems'][$code]) && is_array($data['problems'][$code])) {
                $data['problems'][$code] = collect($data['problems'][$code])
                    ->map(fn ($row) => is_array($row) ? $row : ['value' => $row])
                    ->all();
            }
        }

        return $data;
    }

    public static function normalizeCueValues(array $data): array
    {
        if (! isset($data['cue_values']) || ! is_array($data['cue_values'])) {
            return $data;
        }

        $data['cue_values'] = collect($data['cue_values'])
            ->map(function ($row) {
                if (is_array($row)) {
                    $value = $row['value'] ?? null;
                } else {
                    $value = $row;
                }

                if ($value === null || $value === '') {
                    return null;
                }

                return is_numeric($value) ? (int) $value : (int) preg_replace('/[^0-9-]/', '', (string) $value);
            })
            ->filter(fn ($value) => $value !== null)
            ->values()
            ->all();

        return $data;
    }

    public static function expandCueValues(array $data): array
    {
        if (! isset($data['cue_values']) || ! is_array($data['cue_values'])) {
            return $data;
        }

        $data['cue_values'] = collect($data['cue_values'])
            ->map(fn ($value) => ['value' => $value])
            ->all();

        return $data;
    }
}
