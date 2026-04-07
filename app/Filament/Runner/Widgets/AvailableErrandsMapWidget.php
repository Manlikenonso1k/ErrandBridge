<?php

namespace App\Filament\Runner\Widgets;

use App\Filament\Runner\Resources\ErrandResource;
use App\Models\Errand;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class AvailableErrandsMapWidget extends Widget
{
    protected static string $view = 'filament.runner.widgets.available-errands-map-widget';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public int $radiusMiles = 10;

    public function updateLocation(float $lat, float $lng): void
    {
        $user = Filament::auth()->user();

        if (! $user instanceof User) {
            return;
        }

        $user->forceFill([
            'current_lat' => round($lat, 7),
            'current_lng' => round($lng, 7),
            'is_available' => true,
        ])->save();
    }

    protected function getViewData(): array
    {
        $errands = Errand::query()
            ->where('status', 'pending')
            ->whereNull('runner_id')
            ->whereNotNull('pickup_lat')
            ->whereNotNull('pickup_lng')
            ->get(['id', 'title', 'budget_usdt', 'pickup_lat', 'pickup_lng']);

        $markers = $errands
            ->map(fn (Errand $errand): array => [
                'id' => $errand->id,
                'title' => $errand->title,
                'budget' => (float) $errand->budget_usdt,
                'lat' => (float) $errand->pickup_lat,
                'lng' => (float) $errand->pickup_lng,
                'url' => ErrandResource::getUrl('edit', ['record' => $errand]),
            ])
            ->values()
            ->all();

        return [
            'mapId' => 'runner-available-errands-map-widget',
            'markers' => $markers,
            'center' => [
                'lat' => 6.5244,
                'lng' => 3.3792,
            ],
            'radiusMiles' => $this->radiusMiles,
        ];
    }
}
