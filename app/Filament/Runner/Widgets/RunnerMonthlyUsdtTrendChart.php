<?php

namespace App\Filament\Runner\Widgets;

use App\Models\Payment;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RunnerMonthlyUsdtTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly USDT Trend';

    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $runnerId = Filament::auth()->id();
        $driver = DB::connection()->getDriverName();
        $monthExpression = $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $rows = Payment::query()
            ->where('runner_id', $runnerId)
            ->where('status', 'confirmed')
            ->where('direction', 'release')
            ->selectRaw("{$monthExpression} as month_key, SUM(net_amount) as total")
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->limit(12)
            ->get();

        return [
            'datasets' => [[
                'label' => 'USDT',
                'data' => $rows->pluck('total')->map(fn ($v) => (float) $v)->all(),
            ]],
            'labels' => $rows->pluck('month_key')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
