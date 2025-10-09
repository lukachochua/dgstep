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
            // ────────────────────────────────────────────────
            // Title (translations)
            // ────────────────────────────────────────────────
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

            // Button Texts
            Forms\Components\TextInput::make('button_text.en')->label('Button Text (EN)'),
            Forms\Components\TextInput::make('button_text.ka')->label('Button Text (KA)'),

            // ────────────────────────────────────────────────
            // Primary Button (internal links only)
            // ────────────────────────────────────────────────
            Forms\Components\Hidden::make('link_type')->default('internal'),

            Forms\Components\Placeholder::make('button_route_label')
                ->label('Primary Button Route')
                ->content('Always points to the Contact page.'),

            Forms\Components\Hidden::make('button_route')
                ->default('contact')
                ->dehydrated(),

            Forms\Components\KeyValue::make('button_params')
                ->label('Route parameters')
                ->keyLabel('Param')
                ->valueLabel('Value')
                ->addButtonLabel('Add parameter')
                ->columnSpan('full'),

            // ────────────────────────────────────────────────
            // Secondary Button (optional)
            // ────────────────────────────────────────────────
            Forms\Components\TextInput::make('secondary_button_text.en')->label('Secondary Button Text (EN)'),
            Forms\Components\TextInput::make('secondary_button_text.ka')->label('Secondary Button Text (KA)'),

            Forms\Components\Hidden::make('secondary_link_type')->default('internal'),

            Forms\Components\Select::make('secondary_button_route')
                ->label('Secondary Route name')
                ->options(self::routeOptions())
                ->searchable()
                ->nullable(), // optional

            Forms\Components\KeyValue::make('secondary_button_params')
                ->label('Secondary Route parameters')
                ->keyLabel('Param')
                ->valueLabel('Value')
                ->addButtonLabel('Add parameter')
                ->columnSpan('full'),

            // ────────────────────────────────────────────────
            // Uploads
            // ────────────────────────────────────────────────
            Forms\Components\FileUpload::make('image_path')
                ->label('Background Image')
                ->image()
                ->imageEditor()
                ->disk('public')
                ->directory('hero')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/bmp'])
                ->maxSize(8192) // 8 MB
                ->helperText('Upload a wide 16:9 image (minimum 2560×1440) so it stays sharp on the full-height hero background.'),

            Forms\Components\FileUpload::make('media_paths')
                ->label('Right-side Media Images')
                ->image()
                ->multiple()
                ->reorderable()
                ->imageEditor()
                ->disk('public')
                ->directory('hero_media')
                ->visibility('public')
                ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/bmp'])
                ->maxFiles(6)
                ->maxSize(8192)
                ->helperText('Design for a 16:9 frame (around 1920×1080) to match the right-hand preview mockup.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            // Titles (resolve translations explicitly so they render in the table)
            Tables\Columns\TextColumn::make('title_en')
                ->label('Title (EN)')
                ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'en'))
                ->limit(30),

            Tables\Columns\TextColumn::make('title_ka')
                ->label('Title (KA)')
                ->getStateUsing(fn (HeroSlide $record) => $record->getTranslation('title', 'ka'))
                ->limit(30),

            // Background image (via accessor on model)
            Tables\Columns\ImageColumn::make('image_url')
                ->label('Background')
                ->extraImgAttributes(['alt' => 'Background'])
                ->defaultImageUrl('https://via.placeholder.com/80x48?text=—'),

            // Button links
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
     */
    protected static function routeOptions(): array
    {
        return [
            'home'           => 'Home',
            'about'          => 'About',
            'services'       => 'Services',
            'projects.index' => 'Projects / Index',
            'projects.show'  => 'Projects / Show (requires param)',
            'contact'        => 'Contact',
        ];
    }
}
