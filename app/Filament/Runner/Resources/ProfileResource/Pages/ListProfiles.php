<?php

namespace App\Filament\Runner\Resources\ProfileResource\Pages;

use App\Filament\Runner\Resources\ProfileResource;
use Filament\Resources\Pages\ListRecords;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
