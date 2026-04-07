<?php

namespace App\Filament\Runner\Resources;

use App\Filament\Runner\Resources\WalletResource\Pages;
use App\Models\Payment;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WalletResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $navigationLabel = 'Payment History';

    protected static ?string $navigationGroup = 'EARNINGS';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('errand.title')
                    ->label('Errand Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gross_amount')
                    ->label('Gross Amount')
                    ->money('USD', divideBy: 1),
                Tables\Columns\TextColumn::make('platform_fee')
                    ->label('Platform Fee')
                    ->money('USD', divideBy: 1),
                Tables\Columns\TextColumn::make('tx_hash')
                    ->label('TX Hash')
                    ->url(fn (Payment $record): ?string => $record->tx_hash ? 'https://bscscan.com/tx/' . $record->tx_hash : null)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn (?string $state): string => $state ? substr($state, 0, 12) . '...' : 'N/A'),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'failed' => 'Failed',
                    ]),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('runner_id', Filament::auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWalletTransactions::route('/'),
        ];
    }
}
