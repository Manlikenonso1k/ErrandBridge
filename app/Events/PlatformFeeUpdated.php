<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlatformFeeUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public bool $enabled,
        public float $percentage,
        public User $updatedBy,
    ) {
    }
}