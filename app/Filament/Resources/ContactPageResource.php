<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages;
use App\Models\ContactPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Fieldset::make('Headline & Description')->schema([
                Forms\Components\TextInput::make('headline.en')->label('Headline (EN)')->required(),
                Forms\Components\TextInput::make('headline.ka')->label('Headline (KA)')->required(),
                Forms\Components\Textarea::make('description.en')->label('Description (EN)')->rows(3)->required(),
                Forms\Components\Textarea::make('description.ka')->label('Description (KA)')->rows(3)->required(),
            ])->columns(2),

            Forms\Components\Fieldset::make('Feature Badges')->schema([
                Forms\Components\TextInput::make('feature_professional.en')->label('Professional (EN)')->required(),
                Forms\Components\TextInput::make('feature_professional.ka')->label('Professional (KA)')->required(),
                Forms\Components\TextInput::make('feature_guarantees.en')->label('Guarantees (EN)')->required(),
                Forms\Components\TextInput::make('feature_guarantees.ka')->label('Guarantees (KA)')->required(),
            ])->columns(2),

            Forms\Components\Fieldset::make('CTA')->schema([
                Forms\Components\TextInput::make('cta_button.en')->label('CTA Button (EN)')->required(),
                Forms\Components\TextInput::make('cta_button.ka')->label('CTA Button (KA)')->required(),
                Forms\Components\TextInput::make('cta_phone_href')->label('CTA Phone (href)')->helperText('Used in tel: link')->tel(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('headline')
                    ->label('Headline (EN)')
                    ->formatStateUsing(fn(ContactPage $r) => $r->getTranslation('headline', 'en'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta_phone_href')->label('Phone'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactPages::route('/'),
            'create' => Pages\CreateContactPage::route('/create'),
            'edit' => Pages\EditContactPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationUrl(): string
    {
        $record = ContactPage::query()->latest('id')->first();

        if ($record) {
            return static::getUrl('edit', ['record' => $record]);
        }

        return static::getUrl('create');
    }

    public static function canCreate(): bool
    {
        return ! ContactPage::query()->exists();
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
