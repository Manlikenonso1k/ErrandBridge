<?php

namespace App\Filament\Runner\Resources;

use App\Filament\Runner\Resources\ProfileResource\Pages;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Profile Settings';

    protected static ?string $navigationGroup = 'ACCOUNT';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->maxLength(255),
            Forms\Components\Select::make('city_in_china')
                ->options([
                    'guangzhou' => 'Guangzhou',
                    'yiwu' => 'Yiwu',
                    'shenzhen' => 'Shenzhen',
                    'foshan' => 'Foshan',
                    'dongguan' => 'Dongguan',
                ]),
            Forms\Components\CheckboxList::make('services_offered')
                ->options([
                    'inspection' => 'Inspection',
                    'factory_visits' => 'Factory Visits',
                    'sourcing' => 'Sourcing',
                ]),
            Forms\Components\TextInput::make('availability_hours')
                ->placeholder('e.g. Mon-Fri 08:00-18:00')
                ->maxLength(120),
            Forms\Components\CheckboxList::make('languages')
                ->options([
                    'english' => 'English',
                    'mandarin' => 'Mandarin',
                    'pidgin' => 'Pidgin',
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('city_in_china')->label('City in China'),
                Tables\Columns\TextColumn::make('availability_hours')->label('Availability'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereKey(Filament::auth()->id());
    }

    public static function canCreate(): bool
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
            'index' => Pages\ListProfiles::route('/'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }
}
