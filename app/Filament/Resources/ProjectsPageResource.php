<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectsPageResource\Pages;
use App\Models\ProjectsPage;
use Filament\Forms;
use Filament\Forms\Components\Repeater as RepeaterComponent;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectsPageResource extends Resource
{
    protected static ?string $model = ProjectsPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Projects Page Copy';
    protected static ?string $pluralModelLabel = 'Projects Page Copy';
    protected static ?string $modelLabel = 'Projects Page Copy';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        $locales = static::getLocales();

        return $form->schema([
            Forms\Components\Grid::make()
                ->columns([
                    'sm' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Page Meta')
                            ->icon('heroicon-o-document-text')
                            ->description('Projects-page shell copy and browser metadata.')
                            ->schema([
                                Forms\Components\Tabs::make('meta_locales')
                                    ->persistTabInQueryString()
                                    ->tabs(
                                        collect($locales)->map(function (string $label, string $code) {
                                            return Forms\Components\Tabs\Tab::make($label)
                                                ->icon('heroicon-o-language')
                                                ->schema([
                                                    Forms\Components\TextInput::make("title.$code")
                                                        ->label('Browser title')
                                                        ->maxLength(160)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_kicker.$code")
                                                        ->label('Hero kicker')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]);
                                        })->toArray()
                                    ),
                            ]),
                    ])->columnSpan(['lg' => 1]),

                    Forms\Components\Group::make([
                        Forms\Components\Tabs::make('translations')
                            ->persistTabInQueryString()
                            ->tabs(
                                collect($locales)->map(function (string $label, string $code) {
                                    return Forms\Components\Tabs\Tab::make($label)
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            Forms\Components\Section::make('Hero')
                                                ->icon('heroicon-o-sparkles')
                                                ->schema([
                                                    Forms\Components\TextInput::make("hero_title.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("hero_lead.$code")
                                                        ->label('Lead')
                                                        ->rows(4)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Proof Band')
                                                ->icon('heroicon-o-shield-check')
                                                ->schema([
                                                    Forms\Components\TextInput::make("proof_heading.$code")
                                                        ->label('Heading')
                                                        ->maxLength(180)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("proof_body.$code")
                                                        ->label('Body')
                                                        ->rows(3)
                                                        ->required(),
                                                    RepeaterComponent::make("proof_items.$code")
                                                        ->label('Proof chips')
                                                        ->addActionLabel('Add chip')
                                                        ->default([])
                                                        ->collapsed()
                                                        ->schema([
                                                            Forms\Components\TextInput::make('value')
                                                                ->label('Chip text')
                                                                ->maxLength(180)
                                                                ->required(),
                                                        ])
                                                        ->mutateDehydratedStateUsing(fn ($state) => collect($state)->pluck('value')->filter()->values()->all())
                                                        ->afterStateHydrated(function (RepeaterComponent $component, ?array $state): void {
                                                            $component->state(
                                                                collect($state ?? [])
                                                                    ->map(fn ($item) => ['value' => $item])
                                                                    ->all()
                                                            );
                                                        }),
                                                ]),

                                            Forms\Components\Section::make('Bottom CTA')
                                                ->icon('heroicon-o-megaphone')
                                                ->schema([
                                                    Forms\Components\TextInput::make("cta_heading.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("cta_description.$code")
                                                        ->label('Body')
                                                        ->rows(3)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("cta_label.$code")
                                                        ->label('Button label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),
                                        ]);
                                })->toArray()
                            ),
                    ])->columnSpan(['lg' => 2]),
                ]),

            Forms\Components\Section::make('Project Cards')
                ->icon('heroicon-o-rectangle-stack')
                ->description('Cards shown on the public Projects page.')
                ->schema([
                    RepeaterComponent::make('project_cards')
                        ->label('Projects')
                        ->default([])
                        ->collapsed()
                        ->reorderable()
                        ->addActionLabel('Add project card')
                        ->itemLabel(fn (array $state): string => data_get($state, 'title.en') ?? data_get($state, 'title.ka') ?? 'Project card')
                        ->grid(1)
                        ->columns([
                            'default' => 1,
                            'lg' => 12,
                        ])
                        ->schema([
                            Forms\Components\FileUpload::make('image_path')
                                ->label('Image upload')
                                ->helperText('Optional upload that overrides the external image URL.')
                                ->directory('projects/cards')
                                ->disk('public')
                                ->visibility('public')
                                ->image()
                                ->imageEditor()
                                ->maxFiles(1)
                                ->maxSize(4096)
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 4,
                                ]),
                            Forms\Components\TextInput::make('image_url')
                                ->label('Image URL')
                                ->helperText('Optional fallback when no upload is present.')
                                ->maxLength(2048)
                                ->url()
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 4,
                                ]),
                            Forms\Components\Tabs::make('card_locales')
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 8,
                                ])
                                ->tabs(
                                    collect($locales)->map(function (string $label, string $code) {
                                        return Forms\Components\Tabs\Tab::make($label)
                                            ->schema([
                                                Forms\Components\TextInput::make("title.$code")
                                                    ->label('Title')
                                                    ->maxLength(160)
                                                    ->required(),
                                                Forms\Components\Textarea::make("description.$code")
                                                    ->label('Description')
                                                    ->rows(4)
                                                    ->required(),
                                            ]);
                                    })->toArray()
                                ),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        $locale = app()->getLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make("hero_title->$locale")
                    ->label('Hero title')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime(),
            ])
            ->defaultSort('id')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectsPages::route('/'),
            'edit' => Pages\EditProjectsPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = ProjectsPage::singleton();

        return static::getUrl('edit', ['record' => $record]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getLocales(): array
    {
        return [
            'en' => 'English',
            'ka' => 'ქართული',
        ];
    }
}
