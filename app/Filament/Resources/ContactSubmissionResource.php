<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationParentItem = 'Dashboard';
    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('surname')
                    ->label('Surname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('comments')
                    ->label('Comments')
                    ->toggleable()
                    ->wrap()
                    ->limit(80),
                Tables\Columns\TextColumn::make('locale')
                    ->label('Locale')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No submissions yet');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Contact details')
                    ->schema([
                        TextEntry::make('name')->label('Name'),
                        TextEntry::make('surname')->label('Surname'),
                        TextEntry::make('phone')->label('Phone'),
                        TextEntry::make('locale')->label('Locale')->hidden(fn ($record) => blank($record->locale)),
                        TextEntry::make('ip_address')->label('IP address')->hidden(fn ($record) => blank($record->ip_address)),
                        TextEntry::make('created_at')->label('Submitted at')->dateTime(),
                    ])->columns(2),
                Section::make('Message')
                    ->schema([
                        TextEntry::make('comments')
                            ->label('Comments')
                            ->default('—')
                            ->formatStateUsing(fn (?string $state) => $state ?: '—')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
