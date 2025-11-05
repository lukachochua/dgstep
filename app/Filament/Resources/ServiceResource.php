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
    protected static ?int $navigationSort = 11; // below Hero Slides
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $locales = ['en' => 'English', 'ka' => 'ქართული'];

        return $form->schema([
            Forms\Components\Grid::make(12)->schema([
                // ───────────────────────────────────────────────
                // Main Content
                // ───────────────────────────────────────────────
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
                                                ->label('Short Description')
                                                ->rows(3)
                                                ->required()
                                                ->helperText('Displayed before "Show More".'),

                                            Forms\Components\RichEditor::make("description_expanded.$code")
                                                ->label('Full Description')
                                                ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'link'])
                                                ->helperText('Displayed when user clicks "Show More".')
                                                ->columnSpanFull(),

                                            Forms\Components\Repeater::make("problems.$code")
                                                ->label('Problems (bullet points)')
                                                ->addActionLabel('Add bullet')
                                                ->simple(
                                                    Forms\Components\TextInput::make('value')
                                                        ->label('Problem')
                                                        ->required()
                                                        ->maxLength(200)
                                                        ->placeholder('Manual inventory mistakes')
                                                )
                                                ->defaultItems(0)
                                                ->columnSpanFull()
                                                ->helperText('Shown as bullet points on the homepage cards and services page.'),
                                        ]);
                                })->toArray()
                            ),
                    ]),

                // ───────────────────────────────────────────────
                // Meta / Media
                // ───────────────────────────────────────────────
                Forms\Components\Section::make('Meta')
                    ->columnSpan(4)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(120),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Service Page Image')
                            ->directory('services')
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->downloadable()
                            ->required()
                            ->helperText('Displayed on the services page. Aim for a balanced crop (square or 4:5) so the layout stays even.'),

                        Forms\Components\FileUpload::make('featured_image_path')
                            ->label('Homepage Featured Image')
                            ->directory('services/featured')
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->downloadable()
                            ->helperText('Optional override for the homepage card. Use a wide 16:10 crop (e.g. 1280×800) for best results.'),

                        Forms\Components\TextInput::make('image_alt')
                            ->label('Image alt text')
                            ->maxLength(160)
                            ->helperText('If empty, defaults to English title.'),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Feature on homepage')
                            ->default(false),

                        Forms\Components\TextInput::make('featured_order')
                            ->label('Homepage order (1–3)')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(3)
                            ->default(0)
                            ->visible(fn (Get $get) => (bool) $get('is_featured'))
                            ->helperText('Used only for featured services.'),

                        Forms\Components\TextInput::make('display_order')
                            ->label('Services page order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Lower numbers appear first on the services page.'),
                    ]),
            ]),
        ])->columns(12);
    }

    public static function sanitizeFormData(array $data): array
    {
        $locales = ['en', 'ka'];

        $data['problems'] = collect($locales)
            ->mapWithKeys(function (string $locale) use ($data) {
                $items = $data['problems'][$locale] ?? [];

                if (! is_array($items)) {
                    $items = [];
                }

                $items = collect($items)
                    ->filter(fn ($value) => filled($value))
                    ->map(fn ($value) => is_array($value) ? ($value['value'] ?? null) : $value)
                    ->filter(fn ($value) => filled($value))
                    ->values()
                    ->all();

                return [$locale => $items];
            })
            ->all();

        return $data;
    }

    // ───────────────────────────────────────────────
    // TABLE
    // ───────────────────────────────────────────────
    public static function table(Table $table): Table
    {
        $locale = App::getLocale();

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->square()
                    ->height(48),

                Tables\Columns\TextColumn::make('name_display')
                    ->label('Title')
                    ->getStateUsing(fn (Service $record) => $record->display_name)
                    ->limit(40)
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search) use ($locale) {
                        $query->where("name->$locale", 'like', "%{$search}%")
                              ->orWhere('slug', 'like', "%{$search}%");
                    }),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('featured_order')
                    ->label('Home Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('display_order')
                    ->label('Page Order')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->label('Updated'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('display_order');
    }

    // ───────────────────────────────────────────────
    // RELATIONS
    // ───────────────────────────────────────────────
    public static function getRelations(): array
    {
        return [];
    }

    // ───────────────────────────────────────────────
    // PAGES
    // ───────────────────────────────────────────────
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit'   => Pages\EditService::route('/{record}/edit'),
        ];
    }

}
