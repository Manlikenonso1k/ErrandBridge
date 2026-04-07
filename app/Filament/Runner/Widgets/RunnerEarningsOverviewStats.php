<?php

namespace App\Filament\Runner\Widgets;

use App\Models\Payment;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RunnerEarningsOverviewStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $runnerId = Filament::auth()->id();
        $now = now();

        $currentMonth = Payment::query()
            ->where('runner_id', $runnerId)
            ->where('status', 'confirmed')
            ->where('direction', 'release')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('net_amount');

        $pendingRelease = Payment::query()
            ->where('runner_id', $runnerId)
            ->where('direction', 'release')
            ->where('status', 'pending')
            ->sum('net_amount');

        $allTime = Payment::query()
            ->where('runner_id', $runnerId)
            ->where('status', 'confirmed')
            ->where('direction', 'release')
            ->sum('net_amount');

        return [
            Stat::make('Current Month (USDT)', number_format((float) $currentMonth, 2)),
            Stat::make('Pending Release (USDT)', number_format((float) $pendingRelease, 2)),
            Stat::make('All-Time Earnings (USDT)', number_format((float) $allTime, 2)),
        ];
    }
}
