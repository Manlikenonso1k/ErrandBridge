<?php

namespace App\Filament\Sender\Resources;

use App\Filament\Sender\Resources\ErrandResource\Pages;
use App\Models\Errand;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ErrandResource extends Resource
{
    protected static ?string $model = Errand::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'My Errands';

    protected static ?string $modelLabel = 'Errand';

    protected static ?string $pluralModelLabel = 'Errands';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options([
                        'inspection' => 'Inspection',
                        'delivery' => 'Delivery',
                        'sourcing' => 'Sourcing',
                    ])
                    ->required(),
                Forms\Components\View::make('filament.sender.forms.pickup-map-picker')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pickup_address'),
                Forms\Components\TextInput::make('pickup_lat')
                    ->label('Pickup Latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('pickup_lng')
                    ->label('Pickup Longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_address'),
                Forms\Components\TextInput::make('delivery_lat')
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_lng')
                    ->numeric(),
                Forms\Components\TextInput::make('budget_usdt')
                    ->required()
                    ->numeric()
                    ->prefix('USDT')
                    ->default(0),
                Forms\Components\DateTimePicker::make('deadline'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('sender_id')
                    ->default(fn () => Filament::auth()->id()),
                Forms\Components\Hidden::make('status')
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('runner.name')
                    ->label('Runner')
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
                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'disputed' => 'Disputed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            ->where('sender_id', Filament::auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListErrands::route('/'),
            'create' => Pages\CreateErrand::route('/create'),
            'edit' => Pages\EditErrand::route('/{record}/edit'),
        ];
    }
}
