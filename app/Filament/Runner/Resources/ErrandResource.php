<?php

namespace App\Filament\Runner\Resources;

use App\Filament\Runner\Pages\ErrandDetail;
use App\Filament\Runner\Resources\ErrandResource\Pages;
use App\Models\Errand;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ErrandResource extends Resource
{
    protected static ?string $model = Errand::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'My Errands';

    protected static ?string $navigationGroup = 'ERRANDS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->disabled()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('type')
                    ->disabled()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'accepted' => 'Accepted',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('budget_usdt')
                    ->disabled()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('escrow_tx_hash'),
                Forms\Components\TextInput::make('completion_tx_hash'),
                Forms\Components\DateTimePicker::make('deadline')
                    ->disabled(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Sender')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('budget_usdt')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pickup_address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('delivery_address')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('accept')
                    ->label('Accept')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->visible(fn (Errand $record) => $record->status === 'pending' && $record->runner_id === null)
                    ->action(function (Errand $record): void {
                        $record->update([
                            'runner_id' => Filament::auth()->id(),
                            'status' => 'accepted',
                        ]);

                        Notification::make()
                            ->title('Errand accepted')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('start')
                    ->label('Start')
                    ->icon('heroicon-o-play')
                    ->visible(fn (Errand $record) => $record->status === 'accepted' && $record->runner_id === Filament::auth()->id())
                    ->action(function (Errand $record): void {
                        $record->update(['status' => 'in_progress']);

                        Notification::make()
                            ->title('Errand moved to in progress')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (Errand $record) => $record->status === 'in_progress' && $record->runner_id === Filament::auth()->id())
                    ->requiresConfirmation()
                    ->action(function (Errand $record): void {
                        $record->update(['status' => 'completed']);

                        Notification::make()
                            ->title('Errand completed')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('viewDetail')
                    ->label('View Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Errand $record): string => ErrandDetail::getUrl(['record' => $record->id])),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListErrands::route('/'),
            'edit' => Pages\EditErrand::route('/{record}/edit'),
        ];
    }
}
