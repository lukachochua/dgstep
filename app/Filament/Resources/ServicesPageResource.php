<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicesPageResource\Pages;
use App\Models\ServicesPage;
use Filament\Forms;
use Filament\Forms\Components\Repeater as RepeaterComponent;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServicesPageResource extends Resource
{
    protected static ?string $model = ServicesPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Services Page Copy';
    protected static ?string $pluralModelLabel = 'Services Page Copy';
    protected static ?string $modelLabel = 'Services Page Copy';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 13;

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
                            ->description('Global services-page copy that wraps the repeatable service entries.')
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
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("hero_title.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\Textarea::make("hero_lead.$code")
                                                        ->label('Lead')
                                                        ->rows(4)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make("hero_primary_cta.$code")
                                                        ->label('Primary CTA label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_secondary_cta.$code")
                                                        ->label('Secondary CTA label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Overview Rail')
                                                ->icon('heroicon-o-queue-list')
                                                ->schema([
                                                    Forms\Components\TextInput::make("overview_heading.$code")
                                                        ->label('Heading')
                                                        ->maxLength(180)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("overview_body.$code")
                                                        ->label('Body')
                                                        ->rows(3)
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
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("cta_kicker.$code")
                                                        ->label('Kicker')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("cta_heading.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\Textarea::make("cta_body.$code")
                                                        ->label('Body')
                                                        ->rows(4)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make("cta_primary.$code")
                                                        ->label('Primary button label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("cta_secondary.$code")
                                                        ->label('Secondary button label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Service Card Labels')
                                                ->icon('heroicon-o-pencil-square')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("card_problems_heading.$code")
                                                        ->label('Problems heading')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("card_cta.$code")
                                                        ->label('Primary card CTA')
                                                        ->maxLength(140)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("card_back_to_top.$code")
                                                        ->label('Back-to-top link')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("read_more_label.$code")
                                                        ->label('Read-more toggle')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("show_less_label.$code")
                                                        ->label('Show-less toggle')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),
                                        ]);
                                })->toArray()
                            ),
                    ])->columnSpan(['lg' => 2]),
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
            'index' => Pages\ListServicesPages::route('/'),
            'edit' => Pages\EditServicesPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = ServicesPage::singleton();

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
