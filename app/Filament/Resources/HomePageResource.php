<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomePageResource\Pages;
use App\Models\HomePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomePageResource extends Resource
{
    protected static ?string $model = HomePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Home Page Copy';
    protected static ?string $pluralModelLabel = 'Home Page Copy';
    protected static ?string $modelLabel = 'Home Page Copy';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 11;

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
                            ->description('Shared homepage copy around hero slides and featured services.')
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
                                                        ->maxLength(140)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_secondary_cta.$code")
                                                        ->label('Hero secondary link')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_slide_label.$code")
                                                        ->label('Slide label')
                                                        ->maxLength(80)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_slide_announcement.$code")
                                                        ->label('Slide announcement template')
                                                        ->helperText('Keep :current and :total placeholders.')
                                                        ->maxLength(160)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("hero_image_alt.$code")
                                                        ->label('Hero image alt')
                                                        ->maxLength(180)
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
                                                    Forms\Components\Placeholder::make("hero_summary_$code")
                                                        ->label('Hero structure')
                                                        ->content('This page controls the hero shell only. Slide title, subtitle, primary CTA, image, and ordering are managed under Hero Slides.'),
                                                ]),

                                            Forms\Components\Section::make('Proof Snapshot')
                                                ->icon('heroicon-o-shield-check')
                                                ->description('Intro copy plus three supporting evidence rows.')
                                                ->schema([
                                                    Forms\Components\TextInput::make("proof_kicker.$code")
                                                        ->label('Kicker')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("proof_title.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("proof_subtitle.$code")
                                                        ->label('Subtitle')
                                                        ->rows(4)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Metric Cards')
                                                ->icon('heroicon-o-chart-bar-square')
                                                ->columns(3)
                                                ->schema([
                                                    Forms\Components\Fieldset::make('Focus')
                                                        ->schema([
                                                            Forms\Components\TextInput::make("metric_focus_label.$code")->label('Label')->required(),
                                                            Forms\Components\TextInput::make("metric_focus_value.$code")->label('Value')->required(),
                                                            Forms\Components\Textarea::make("metric_focus_description.$code")->label('Description')->rows(3)->required(),
                                                        ]),
                                                    Forms\Components\Fieldset::make('Technology')
                                                        ->schema([
                                                            Forms\Components\TextInput::make("metric_technology_label.$code")->label('Label')->required(),
                                                            Forms\Components\TextInput::make("metric_technology_value.$code")->label('Value')->required(),
                                                            Forms\Components\Textarea::make("metric_technology_description.$code")->label('Description')->rows(3)->required(),
                                                        ]),
                                                    Forms\Components\Fieldset::make('Approach')
                                                        ->schema([
                                                            Forms\Components\TextInput::make("metric_approach_label.$code")->label('Label')->required(),
                                                            Forms\Components\TextInput::make("metric_approach_value.$code")->label('Value')->required(),
                                                            Forms\Components\Textarea::make("metric_approach_description.$code")->label('Description')->rows(3)->required(),
                                                        ]),
                                                ]),

                                            Forms\Components\Section::make('Featured Services Intro')
                                                ->icon('heroicon-o-rectangle-stack')
                                                ->description('Section heading and intro for the featured services block.')
                                                ->schema([
                                                    Forms\Components\TextInput::make("solutions_kicker.$code")
                                                        ->label('Kicker')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("solutions_title.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required(),
                                                    Forms\Components\Textarea::make("solutions_subtitle.$code")
                                                        ->label('Subtitle')
                                                        ->rows(3)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("solutions_link_label.$code")
                                                        ->label('Card link label')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Closing CTA')
                                                ->icon('heroicon-o-megaphone')
                                                ->description('Quiet closing call to action with one primary button and one text link.')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("cta_title.$code")
                                                        ->label('Headline')
                                                        ->maxLength(255)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\Textarea::make("cta_subtitle.$code")
                                                        ->label('Subtitle')
                                                        ->rows(4)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make("cta_primary.$code")
                                                        ->label('Primary button')
                                                        ->maxLength(120)
                                                        ->required(),
                                                    Forms\Components\TextInput::make("cta_secondary.$code")
                                                        ->label('Secondary button')
                                                        ->maxLength(120)
                                                        ->required(),
                                                ]),

                                            Forms\Components\Section::make('Floating CTA')
                                                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                                                ->description('Small delayed homepage prompt in the bottom-right corner.')
                                                ->columns(2)
                                                ->schema([
                                                    Forms\Components\TextInput::make("floating_cta_title.$code")
                                                        ->label('Prompt title')
                                                        ->maxLength(160)
                                                        ->required()
                                                        ->columnSpanFull(),
                                                    Forms\Components\TextInput::make("floating_cta_primary.$code")
                                                        ->label('Primary button')
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
                Tables\Columns\TextColumn::make("title->$locale")
                    ->label('Home title')
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
            'index' => Pages\ListHomePages::route('/'),
            'edit' => Pages\EditHomePage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = HomePage::singleton();

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
