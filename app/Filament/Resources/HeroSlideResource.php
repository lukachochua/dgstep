<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

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
                ->description('Edit the slide order, title, subtitle, and image. Shared hero action labels are managed under Home Page Copy; their destinations remain Contact and Services.')
                ->schema([
                    TextInput::make('sort_order')
                        ->label('Slide order')
                        ->numeric()
                        ->minValue(1)
                        ->required(),

                    Tabs::make('translations')
                        ->tabs([
                            Tab::make('English')
                                ->schema([
                                    TextInput::make('title.en')
                                        ->label('Title (EN)')
                                        ->required()
                                        ->maxLength(255),
                                    Textarea::make('subtitle.en')
                                        ->label('Subtitle (EN)')
                                        ->rows(5)
                                        ->autosize(),
                                ])
                                ->columns(1),
                            Tab::make('ქართული')
                                ->schema([
                                    TextInput::make('title.ka')
                                        ->label('სათაური (KA)')
                                        ->required()
                                        ->maxLength(255),
                                    Textarea::make('subtitle.ka')
                                        ->label('ქვე-სათაური (KA)')
                                        ->rows(5)
                                        ->autosize(),
                                ])
                                ->columns(1),
                        ])
                        ->columnSpanFull(),
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

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

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

                TextColumn::make('subtitle_en')
                    ->label('Subtitle (EN)')
                    ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('subtitle', 'en') ?? '—')
                    ->limit(60)
                    ->wrap(),

                ImageColumn::make('background_preview')
                    ->label('Background')
                    ->getStateUsing(function (HeroSlide $record): ?string {
                        if (! $record->image_path) {
                            return null;
                        }

                        if (str_starts_with($record->image_path, 'http://') || str_starts_with($record->image_path, 'https://')) {
                            return $record->image_path;
                        }

                        return Storage::disk('public')->url($record->image_path);
                    })
                    ->circular(false)
                    ->size(48),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->toggleable(),
            ])
            ->defaultSort('sort_order')
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

}
