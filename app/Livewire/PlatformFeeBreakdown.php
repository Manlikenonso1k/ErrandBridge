<?php

namespace App\Livewire;

use App\Services\PlatformFeeService;
use Livewire\Component;

class PlatformFeeBreakdown extends Component
{
    public float $amount = 0;

    public function mount(float $amount = 0): void
    {
        $this->amount = $amount;
    }

    public function render(PlatformFeeService $platformFeeService)
    {
        return view('livewire.platform-fee-breakdown', [
            'breakdown' => $platformFeeService->calculate($this->amount),
        ]);
    }
}