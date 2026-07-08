<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageResource\Pages;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Forms\Components\Repeater as RepeaterComponent;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 40;
    protected static ?string $modelLabel = 'About Page';
    protected static ?string $pluralModelLabel = 'About Page';
    protected static ?string $navigationLabel = 'About Page';

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
                        Forms\Components\Section::make('Hero Media')
                            ->icon('heroicon-o-photo')
                            ->description('Update the hero background imagery that appears at the top of the About page.')
                            ->collapsible()
                            ->schema([
                                Forms\Components\FileUpload::make('hero_image_path')
                                    ->label('Hero image upload')
                                    ->helperText('Upload a hero image (overrides the external URL when provided). Ideal size 1200×760.')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('about/hero')
                                    ->visibility('public')
                                    ->maxSize(8192)
                                    ->imagePreviewHeight('200')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('hero_image_url')
                                    ->label('Hero image URL')
                                    ->helperText('Optional fallback when no upload is provided. Paste a fully qualified URL.')
                                    ->maxLength(2048)
                                    ->url()
                                    ->nullable(),
                            ]),
                    ])->columnSpan(['lg' => 1]),

                    Forms\Components\Group::make([
                        Forms\Components\Tabs::make('Translations')
                            ->persistTabInQueryString()
                            ->tabs(
                                collect($locales)->map(function (string $label, string $code) {
                                    return Forms\Components\Tabs\Tab::make($label)
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            Forms\Components\Section::make('Page Title & Hero Copy')
                                                ->icon('heroicon-o-sparkles')
                                                ->description('Localized browser title and hero image metadata.')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("title.$code")
                                                        ->label('Page title')
                                                        ->maxLength(160)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_image_alt.$code")
                                                        ->label('Hero image alt text')
                                                        ->maxLength(180),
                                                ]),

                                            Forms\Components\Section::make('Hero copy')
                                                ->icon('heroicon-o-user-group')
                                                ->description('The circle label stays fixed on the front end; only these intro paragraphs are editable.')
                                                ->schema([
                                                    Forms\Components\Textarea::make("who_paragraph_1.$code")
                                                        ->label('Paragraph 1')
                                                        ->rows(4)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("who_paragraph_2.$code")
                                                        ->label('Paragraph 2')
                                                        ->rows(4),
                                                ]),

                                            Forms\Components\Section::make('Mission copy')
                                                ->icon('heroicon-o-flag')
                                                ->schema([
                                                    Forms\Components\TextInput::make("mission_heading.$code")
                                                        ->label('Mission heading')
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make("mission_label.$code")
                                                        ->label('Mission label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("mission_description.$code")
                                                        ->label('Mission description')
                                                        ->rows(4)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Vision copy')
                                                ->icon('heroicon-o-light-bulb')
                                                ->schema([
                                                    Forms\Components\TextInput::make("vision_heading.$code")
                                                        ->label('Vision heading')
                                                        ->maxLength(255),
                                                    Forms\Components\TextInput::make("vision_label.$code")
                                                        ->label('Vision label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("vision_description.$code")
                                                        ->label('Vision description')
                                                        ->rows(4)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Delivery method')
                                                ->icon('heroicon-o-arrow-path')
                                                ->description('Copy shown above the operating workflow on the public About page.')
                                                ->schema([
                                                    Forms\Components\TextInput::make("delivery_kicker.$code")
                                                        ->label('Kicker')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("delivery_title.$code")
                                                        ->label('Heading')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("delivery_description.$code")
                                                        ->label('Description')
                                                        ->rows(3)
                                                        ->required(),
                                                ]),

                                        ]);
                                })->toArray()
                            ),
                    ])->columnSpan(['lg' => 2]),
                ]),

            Forms\Components\Section::make('Delivery workflow steps')
                ->icon('heroicon-o-list-bullet')
                ->description('Ordered operating stages shown on the public About page.')
                ->schema([
                    RepeaterComponent::make('delivery_steps')
                        ->label('Steps')
                        ->orderable()
                        ->collapsed()
                        ->default([])
                        ->minItems(1)
                        ->createItemButtonLabel('Add step')
                        ->itemLabel(fn (array $state): string => data_get($state, 'title.en') ?? data_get($state, 'title.ka') ?? 'Workflow step')
                        ->schema([
                            Forms\Components\Tabs::make('step_locales')
                                ->tabs(
                                    collect(static::getLocales())->map(function (string $label, string $code) {
                                        return Forms\Components\Tabs\Tab::make($label)
                                            ->schema([
                                                Forms\Components\TextInput::make("title.$code")
                                                    ->label('Step title')
                                                    ->maxLength(160)
                                                    ->required(),
                                                Forms\Components\Textarea::make("description.$code")
                                                    ->label('Step description')
                                                    ->rows(3)
                                                    ->maxLength(600)
                                                    ->required(),
                                            ]);
                                    })->toArray()
                                ),
                        ])
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        $locale = app()->getLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title->$locale")
                    ->label('Title')
                    ->limit(40)
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
            'index' => Pages\ListAboutPages::route('/'),
            'edit' => Pages\EditAboutPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = AboutPage::singleton();

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
