<?php

namespace App\Filament\Runner\Pages;

use App\Filament\Runner\Pages\MyReviews;
use App\Filament\Runner\Resources\ErrandResource;
use App\Models\Errand;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class RunnerMap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationGroup = 'ERRANDS';

    protected static ?string $navigationLabel = 'Errand Map';

    protected static ?string $title = null;

    protected static string $view = 'filament.runner.pages.runner-map';

    public function getHeading(): string
    {
        return '';
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
            'markers' => $markers,
            'links' => [
                'map' => self::getUrl(),
                'available' => ErrandResource::getUrl('index'),
                'myErrands' => ErrandResource::getUrl('index'),
                'reviews' => MyReviews::getUrl(),
            ],
        ];
    }

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
}
