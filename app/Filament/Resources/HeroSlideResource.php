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
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 10; 

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
            Forms\Components\TextInput::make('highlight.en')->label('Highlight (EN)'),
            Forms\Components\TextInput::make('highlight.ka')->label('Highlight (KA)'),

            // Subtitle
            Forms\Components\Textarea::make('subtitle.en')->label('Subtitle (EN)'),
            Forms\Components\Textarea::make('subtitle.ka')->label('Subtitle (KA)'),

            // Button Text
            Forms\Components\TextInput::make('button_text.en')->label('Button Text (EN)'),
            Forms\Components\TextInput::make('button_text.ka')->label('Button Text (KA)'),

            // ────────────────────────────────────────────────────────────────
            // Button Link (Backwards-compatible + Better Routing)
            // ────────────────────────────────────────────────────────────────

            Forms\Components\Hidden::make('link_type')
                ->default('internal')
                ->afterStateHydrated(fn ($component) => $component->state('internal')),

            // 2) Internal route name (curated list)
            Forms\Components\Select::make('button_route')
                ->label('Route name')
                ->options(self::routeOptions())
                ->searchable()
                ->required(),

            // 3) Internal route params (key/value)
            Forms\Components\KeyValue::make('button_params')
                ->label('Route parameters')
                ->keyLabel('Param')
                ->valueLabel('Value')
                ->addButtonLabel('Add parameter')
                ->columnSpan('full'),
            Forms\Components\Hidden::make('button_link'),
            Forms\Components\Hidden::make('button_url'),

            // Secondary Button Text
            Forms\Components\TextInput::make('secondary_button_text.en')->label('Secondary Button Text (EN)'),
            Forms\Components\TextInput::make('secondary_button_text.ka')->label('Secondary Button Text (KA)'),

            // Secondary Button Link settings
            Forms\Components\Hidden::make('secondary_link_type')
                ->default('internal')
                ->afterStateHydrated(fn ($component) => $component->state('internal')),

            Forms\Components\Select::make('secondary_button_route')
                ->label('Secondary Route name')
                ->options(self::routeOptions())
                ->searchable()
                ->required(),

            Forms\Components\KeyValue::make('secondary_button_params')
                ->label('Secondary Route parameters')
                ->keyLabel('Param')
                ->valueLabel('Value')
                ->addButtonLabel('Add parameter')
                ->columnSpan('full'),

            Forms\Components\Hidden::make('secondary_button_link'),
            Forms\Components\Hidden::make('secondary_button_url'),

            // Background Image (stored at storage/app/public/hero/...)
            Forms\Components\FileUpload::make('image_path')
                ->label('Background Image')
                ->image()
                ->disk('public')
                ->directory('hero')
                ->maxSize(2048),

            // Right-side Media Images (stored at storage/app/public/hero_media/...)
            Forms\Components\FileUpload::make('media_paths')
                ->label('Right-side Media Images')
                ->image()
                ->multiple()
                ->disk('public')
                ->directory('hero_media')
                ->maxFiles(6)
                ->maxSize(4096),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title_en')
                ->label('Title (EN)')
                ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'en'))
                ->limit(30),

            Tables\Columns\TextColumn::make('title_ka')
                ->label('Title (KA)')
                ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'ka'))
                ->limit(30),

            // Use the accessor, not the raw DB field
            Tables\Columns\ImageColumn::make('image_url')
                ->label('Background')
                ->extraImgAttributes(['alt' => 'Background'])
                ->defaultImageUrl('https://via.placeholder.com/80x48?text=—'),

            // NEW: Always show the resolved, safe href (works for internal/external/legacy)
            Tables\Columns\TextColumn::make('button_href')
                ->label('Button Link')
                ->url(fn (HeroSlide $record) => $record->button_href)
                ->openUrlInNewTab()
                ->limit(40),

            Tables\Columns\TextColumn::make('secondary_button_href')
                ->label('Secondary Link')
                ->url(fn (HeroSlide $record) => $record->secondary_button_href)
                ->openUrlInNewTab()
                ->limit(40),

            Tables\Columns\TextColumn::make('created_at')->dateTime(),
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

    /**
     * Curated list of internal route names for editors.
     * Add/remove to match your app's public routes.
     */
    protected static function routeOptions(): array
    {
        return [
            'home'            => 'Home',
            'about'           => 'About',
            'services'        => 'Services',
            'projects.index'  => 'Projects / Index',
            'projects.show'   => 'Projects / Show (requires param)',
            'contact'         => 'Contact',
        ];
    }
}
