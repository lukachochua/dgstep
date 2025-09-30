<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Filament\Resources\HeroSlideResource\RelationManagers;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content'; // groups sidebar items

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required()
                ->translatable(),

            Forms\Components\TextInput::make('highlight')
                ->label('Highlight')
                ->translatable(),

            Forms\Components\Textarea::make('subtitle')
                ->label('Subtitle')
                ->translatable(),

            Forms\Components\TextInput::make('button_text')
                ->label('Button Text')
                ->translatable(),

            Forms\Components\TextInput::make('button_link')
                ->label('Button Link')
                ->url(),

            Forms\Components\FileUpload::make('image_path')
                ->label('Hero Image')
                ->image()
                ->directory('hero')
                ->maxSize(2048),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->limit(30)
                    ->translatable(),

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