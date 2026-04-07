<?php

namespace App\Filament\Runner\Resources;

use App\Filament\Runner\Resources\RunnerKycSubmissionResource\Pages;
use App\Models\KycSubmission;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RunnerKycSubmissionResource extends Resource
{
    protected static ?string $model = KycSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'KYC';

    protected static ?string $navigationGroup = 'ACCOUNT';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('document_path')
                ->disk('public')
                ->directory('kyc')
                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                ->required(),
            Forms\Components\Textarea::make('notes')->maxLength(1000),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Submitted'),
                Tables\Columns\TextColumn::make('reviewed_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Filament::auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRunnerKycSubmissions::route('/'),
            'create' => Pages\CreateRunnerKycSubmission::route('/create'),
            'edit' => Pages\EditRunnerKycSubmission::route('/{record}/edit'),
        ];
    }
}
