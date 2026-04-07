<?php

namespace App\Filament\Sender\Widgets;

use App\Models\Errand;
use App\Models\Payment;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class SenderStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $userId = Filament::auth()->id();

        $totalErrands = Errand::query()->where('sender_id', $userId)->count();
        $activeErrands = Errand::query()
            ->where('sender_id', $userId)
            ->whereIn('status', ['pending', 'accepted', 'in_progress'])
            ->count();
        $totalSpent = Payment::query()->where('sender_id', $userId)->sum('amount_usdt');

        return [
            Card::make('Total Errands', (string) $totalErrands),
            Card::make('Active Errands', (string) $activeErrands),
            Card::make('Total USDT Spent', number_format((float) $totalSpent, 2)),
        ];
    }
}
