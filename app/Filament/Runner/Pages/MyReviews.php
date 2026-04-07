<?php

namespace App\Filament\Runner\Pages;

use App\Models\RunnerReview;
use Filament\Facades\Filament;
use Filament\Pages\Page;

class MyReviews extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'My Reviews';

    protected static ?string $navigationGroup = 'ERRANDS';

    protected static string $view = 'filament.runner.pages.my-reviews';

    public function getAverageRating(): float
    {
        return (float) RunnerReview::query()
            ->where('runner_id', Filament::auth()->id())
            ->avg('stars');
    }

    public function getReviews()
    {
        return RunnerReview::query()
            ->with(['sender', 'errand'])
            ->where('runner_id', Filament::auth()->id())
            ->latest()
            ->get();
    }
}
