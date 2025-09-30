<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content'; // groups sidebar items

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Title
            Forms\Components\TextInput::make('title.en')
                ->label('Title (EN)')
                ->required(),

            Forms\Components\TextInput::make('title.ka')
                ->label('Title (KA)')
                ->required(),

            // Highlight
            Forms\Components\TextInput::make('highlight.en')
                ->label('Highlight (EN)'),

            Forms\Components\TextInput::make('highlight.ka')
                ->label('Highlight (KA)'),

            // Subtitle
            Forms\Components\Textarea::make('subtitle.en')
                ->label('Subtitle (EN)'),

            Forms\Components\Textarea::make('subtitle.ka')
                ->label('Subtitle (KA)'),

            // Button Text
            Forms\Components\TextInput::make('button_text.en')
                ->label('Button Text (EN)'),

            Forms\Components\TextInput::make('button_text.ka')
                ->label('Button Text (KA)'),

            // Button Link
            Forms\Components\TextInput::make('button_link')
                ->label('Button Link')
                ->url(),

            // Image Upload
            Forms\Components\FileUpload::make('image_path')
                ->label('Hero Image')
                ->image()
                ->directory('hero')
                ->maxSize(2048),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'en'))
                    ->limit(30),

                Tables\Columns\TextColumn::make('title_ka')
                    ->label('Title (KA)')
                    ->getStateUsing(fn ($record) => $record->getTranslation('title', 'ka'))
                    ->limit(30),

                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
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
