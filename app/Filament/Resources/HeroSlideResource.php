<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 10;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Section::make(__('Hero Content'))
                ->schema([
                    Tabs::make('translations')
                        ->tabs([
                            Tab::make('English')
                                ->schema([
                                    TextInput::make('title.en')
                                        ->label('Title (EN)')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('highlight.en')
                                        ->label('Highlight (EN)')
                                        ->maxLength(255),
                                    Textarea::make('subtitle.en')
                                        ->label('Subtitle (EN)')
                                        ->rows(3)
                                        ->autosize(),
                                    TextInput::make('button_text.en')
                                        ->label('Primary Button Text (EN)')
                                        ->maxLength(255),
                                ])
                                ->columns(1),
                            Tab::make('ქართული')
                                ->schema([
                                    TextInput::make('title.ka')
                                        ->label('სათაური (KA)')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('highlight.ka')
                                        ->label('გამოკვეთილი ტექსტი (KA)')
                                        ->maxLength(255),
                                    Textarea::make('subtitle.ka')
                                        ->label('ქვე-სათაური (KA)')
                                        ->rows(3)
                                        ->autosize(),
                                    TextInput::make('button_text.ka')
                                        ->label('ძირითადი ღილაკი (KA)')
                                        ->maxLength(255),
                                ])
                                ->columns(1),
                        ])
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Primary Action')
                ->schema([
                    ToggleButtons::make('link_type')
                        ->label('Link Type')
                        ->inline()
                        ->options([
                            'internal' => 'Internal route',
                            'external' => 'External URL',
                            'legacy'   => 'Direct link',
                        ])
                        ->colors([
                            'internal' => 'primary',
                            'external' => 'success',
                            'legacy'   => 'gray',
                        ])
                        ->reactive()
                        ->default('internal'),

                    Forms\Components\Select::make('button_route')
                        ->label('Route name')
                        ->options(self::routeOptions())
                        ->searchable()
                        ->helperText('Choose a named route from the site to link this slide to.')
                        ->visible(fn (callable $get) => $get('link_type') === 'internal')
                        ->required(fn (callable $get) => $get('link_type') === 'internal'),

                    KeyValue::make('button_params')
                        ->label('Route parameters')
                        ->keyLabel('Parameter')
                        ->valueLabel('Value')
                        ->visible(fn (callable $get) => $get('link_type') === 'internal')
                        ->helperText('Optional route parameters (e.g. slug → dgstep).')
                        ->columnSpanFull(),

                    TextInput::make('button_url')
                        ->label('External URL')
                        ->placeholder('https://example.com')
                        ->url()
                        ->visible(fn (callable $get) => $get('link_type') === 'external')
                        ->required(fn (callable $get) => $get('link_type') === 'external')
                        ->maxLength(512),

                    TextInput::make('button_link')
                        ->label('Direct link')
                        ->placeholder('/contact')
                        ->visible(fn (callable $get) => $get('link_type') === 'legacy')
                        ->required(fn (callable $get) => $get('link_type') === 'legacy')
                        ->maxLength(512),
                ])
                ->columns(2),

            Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Background image')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('hero')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/bmp'])
                        ->maxSize(8192)
                        ->helperText('Wide 16:9 image (≥2560×1440) recommended for the hero background.'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'en') ?? '—')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('title_ka')
                    ->label('Title (KA)')
                    ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'ka') ?? '—')
                    ->limit(40)
                    ->searchable(),

                BadgeColumn::make('link_type')
                    ->label('Primary link')
                    ->formatStateUsing(fn (?string $state) => $state ? Str::headline($state) : '—')
                    ->colors([
                        'primary' => ['internal'],
                        'success' => ['external'],
                        'gray'    => ['legacy'],
                    ]),

                TextColumn::make('button_href')
                    ->label('Button URL')
                    ->limit(40)
                    ->url(fn (HeroSlide $record) => $record->button_href)
                    ->openUrlInNewTab(),

                ImageColumn::make('image_url')
                    ->label('Background')
                    ->circular(false)
                    ->size(48),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('id')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit'   => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }

    protected static function routeOptions(): array
    {
        return [
            'home'     => 'home',
            'about'    => 'about',
            'services' => 'services',
            'projects' => 'projects',
            'contact'  => 'contact',
            'terms'    => 'terms',
        ];
    }
}
