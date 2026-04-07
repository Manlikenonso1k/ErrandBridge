<?php

namespace App\Filament\Sender\Resources\ErrandResource\Pages;

use App\Filament\Sender\Resources\ErrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListErrands extends ListRecords
{
    protected static string $resource = ErrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
