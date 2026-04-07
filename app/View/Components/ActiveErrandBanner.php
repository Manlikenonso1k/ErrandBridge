<?php

namespace App\View\Components;

use App\Models\Errand;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActiveErrandBanner extends Component
{
    public function render(): View
    {
        $errand = null;

        $errandId = session('active_errand_id');

        if ($errandId) {
            $errand = Errand::query()
                ->whereKey($errandId)
                ->where('runner_id', Filament::auth()->id())
                ->whereIn('status', ['accepted', 'in_progress'])
                ->first();
        }

        if (! $errand) {
            $errand = Errand::query()
                ->where('runner_id', Filament::auth()->id())
                ->whereIn('status', ['accepted', 'in_progress'])
                ->latest('updated_at')
                ->first();
        }

        return view('components.active-errand-banner', [
            'errand' => $errand,
        ]);
    }
}
