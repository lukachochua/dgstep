<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicesPageResource\Pages;
use App\Models\ServicesPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class ServicesPageResource extends Resource
{
    protected static ?string $model = ServicesPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Page')->schema([
                Forms\Components\Fieldset::make('Title')->schema([
                    Forms\Components\TextInput::make('title.en')->label('Title (EN)')->required(),
                    Forms\Components\TextInput::make('title.ka')->label('Title (KA)')->required(),
                ]),
            ])->columns(2),

            Forms\Components\Section::make('Services')->schema([
                Forms\Components\Repeater::make('sections')
                    ->reorderable()
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\TextInput::make('key')->label('Key')->required()
                            ->helperText('slug-like identifier (e.g., pawnshop, smb, compliance)'),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('title.en')->label('Title (EN)')->required(),
                            Forms\Components\TextInput::make('title.ka')->label('Title (KA)')->required(),
                        ]),

                        Forms\Components\Textarea::make('description.en')->label('Description (EN)')->rows(3)->required(),
                        Forms\Components\Textarea::make('description.ka')->label('Description (KA)')->rows(3)->required(),

                        Forms\Components\Select::make('cue_style')->label('Cue Style')->options([
                            'bubbles' => 'Bubbles',
                            'bars'    => 'Bars',
                            'dots'    => 'Dots',
                        ])->required(),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('cue_label.en')->label('Cue Label (EN)'),
                            Forms\Components\TextInput::make('cue_label.ka')->label('Cue Label (KA)'),
                        ]),

                        Forms\Components\KeyValue::make('cue_values')->label('Cue Values')
                            ->keyLabel('Index')->valueLabel('Value')->addButtonLabel('Add')
                            ->helperText('Bars/Bubbles: 0–100. Dots: 1=on, 0=off.')
                            ->default([]),
                    ])->columns(1),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            // Keep an index shim (optional; helps breadcrumbs)
            'index' => Pages\ListServicesPages::route('/'),
            // IMPORTANT: include {record} so EditRecord::mount($record) is satisfied
            'edit'  => Pages\EditServicesPage::route('/{record}'),
        ];
    }

    /** Make the sidebar link jump straight to the singleton’s edit URL. */
    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', [
            'record' => ServicesPage::singleton()->getKey(),
        ]);
    }
}
