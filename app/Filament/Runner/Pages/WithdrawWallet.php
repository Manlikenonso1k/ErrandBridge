<?php

namespace App\Filament\Runner\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;

class WithdrawWallet extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Withdraw / Wallet';

    protected static ?string $navigationGroup = 'EARNINGS';

    protected static string $view = 'filament.runner.pages.withdraw-wallet';

    public static function getNetworkStatus(): string
    {
        return 'BNB Chain Mainnet';
    }

    public function getWalletAddress(): ?string
    {
        return Filament::auth()->user()?->wallet_address;
    }
}
