<?php

namespace App\Filament\Sender\Widgets;

use App\Filament\Sender\Resources\ErrandResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\Widget;

class RunnerMapWidget extends Widget
{
    protected static string $view = 'filament.sender.widgets.runner-map-widget';

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
        ])->save();
    }

    protected function getViewData(): array
    {
        $runners = User::query()
            ->role('runner')
            ->where('is_available', true)
            ->whereNotNull('current_lat')
            ->whereNotNull('current_lng')
            ->get(['id', 'name', 'current_lat', 'current_lng']);

        $markers = $runners
            ->map(fn (User $runner): array => [
                'id' => $runner->id,
                'name' => $runner->name,
                'lat' => (float) $runner->current_lat,
                'lng' => (float) $runner->current_lng,
            ])
            ->values()
            ->all();

        return [
            'mapId' => 'sender-runner-map-widget',
            'markers' => $markers,
            'center' => [
                'lat' => 6.5244,
                'lng' => 3.3792,
            ],
            'postErrandUrl' => ErrandResource::getUrl('create'),
            'googleMapsApiKey' => (string) config('services.google_maps.key', ''),
            'radiusMiles' => $this->radiusMiles,
        ];
    }
}
