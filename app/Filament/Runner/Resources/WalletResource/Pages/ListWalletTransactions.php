<?php

namespace App\Filament\Runner\Resources\WalletResource\Pages;

use App\Filament\Runner\Resources\WalletResource;
use Filament\Resources\Pages\ListRecords;

class ListWalletTransactions extends ListRecords
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
