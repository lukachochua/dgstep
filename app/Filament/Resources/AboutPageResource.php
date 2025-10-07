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
    protected static ?int $navigationSort = 30;
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
                                Forms\Components\TextInput::make('hero_image_url')
                                    ->label('Hero image URL')
                                    ->helperText('Paste a fully qualified image URL. Ideal size 1200×760.')
                                    ->maxLength(2048)
                                    ->url()
                                    ->required(),
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
                                                ->description('Localized headline visible on the hero and browser tab.')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("title.$code")
                                                        ->label('Page title')
                                                        ->maxLength(160)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_caption.$code")
                                                        ->label('Hero caption')
                                                        ->maxLength(180),
                                                    Forms\Components\TextInput::make("hero_status_label.$code")
                                                        ->label('Hero status label')
                                                        ->maxLength(120),
                                                    Forms\Components\TextInput::make("hero_image_alt.$code")
                                                        ->label('Hero image alt text')
                                                        ->maxLength(180),
                                                ]),

                                            Forms\Components\Section::make('Who we are')
                                                ->icon('heroicon-o-user-group')
                                                ->schema([
                                                    Forms\Components\TextInput::make("who_heading.$code")
                                                        ->label('Heading')
                                                        ->maxLength(255)
                                                        ->required(),
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

                                            Forms\Components\Section::make('Management copy')
                                                ->icon('heroicon-o-briefcase')
                                                ->columns(3)
                                                ->schema([
                                                    Forms\Components\TextInput::make("management_heading.$code")
                                                        ->label('Heading')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("management_view_all.$code")
                                                        ->label('View-all label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("management_collapse.$code")
                                                        ->label('Collapse label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Badge chips')
                                                ->icon('heroicon-o-bookmark')
                                                ->description('Short highlights rendered as pills below the hero copy.')
                                                ->schema([
                                                    RepeaterComponent::make("badges.$code")
                                                        ->label('Badges for this locale')
                                                        ->addActionLabel('Add badge')
                                                        ->maxItems(5)
                                                        ->grid(1)
                                                        ->default([])
                                                        ->orderable()
                                                        ->collapsed()
                                                        ->schema([
                                                            Forms\Components\TextInput::make('value')
                                                                ->label('Badge text')
                                                                ->maxLength(120)
                                                                ->required(),
                                                        ])
                                                        ->mutateDehydratedStateUsing(fn ($state) => collect($state)->pluck('value')->filter()->values()->all())
                                                        ->afterStateHydrated(function (RepeaterComponent $component, ?array $state): void {
                                                            $component->state(
                                                                collect($state ?? [])
                                                                    ->map(fn ($badge) => ['value' => $badge])
                                                                    ->all()
                                                            );
                                                        }),
                                                ]),
                                        ]);
                                })->toArray()
                            ),
                    ])->columnSpan(['lg' => 2]),
                ]),

            Forms\Components\Section::make('Management Team')
                ->icon('heroicon-o-users')
                ->description('Manage the carousel/grid entries that surface on the public About page.')
                ->collapsible()
                ->schema([
                    RepeaterComponent::make('management_members')
                        ->label('Members')
                        ->orderable()
                        ->collapsed()
                        ->default([])
                        ->createItemButtonLabel('Add member')
                        ->itemLabel(fn (array $state): string => data_get($state, 'name.en') ?? data_get($state, 'name', 'Team member'))
                        ->columns([
                            'default' => 1,
                            'lg' => 12,
                        ])
                        ->grid(1)
                        ->schema([
                            Forms\Components\TextInput::make('image_url')
                                ->label('Image URL')
                                ->maxLength(2048)
                                ->url()
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 4,
                                ]),

                            Forms\Components\Tabs::make('member_locales')
                                ->columnSpan([
                                    'default' => 1,
                                    'lg' => 8,
                                ])
                                ->tabs(
                                    collect(static::getLocales())->map(function (string $label, string $code) {
                                        return Forms\Components\Tabs\Tab::make($label)
                                            ->schema([
                                                Forms\Components\TextInput::make("name.$code")
                                                    ->label('Name')
                                                    ->maxLength(120),
                                                Forms\Components\TextInput::make("role.$code")
                                                    ->label('Role')
                                                    ->maxLength(160),
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
