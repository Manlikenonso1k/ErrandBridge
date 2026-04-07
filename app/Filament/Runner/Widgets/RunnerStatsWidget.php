<?php

namespace App\Filament\Runner\Widgets;

use App\Models\Errand;
use App\Models\Payment;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class RunnerStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $runnerId = Filament::auth()->id();

        $availableJobs = Errand::query()->where('status', 'pending')->whereNull('runner_id')->count();
        $completedJobs = Errand::query()->where('runner_id', $runnerId)->where('status', 'completed')->count();
        $usdtEarned = Payment::query()->where('runner_id', $runnerId)->sum('amount_usdt');

        return [
            Card::make('Available Jobs', (string) $availableJobs),
            Card::make('Completed Jobs', (string) $completedJobs),
            Card::make('USDT Earned', number_format((float) $usdtEarned, 2)),
        ];
    }
}
