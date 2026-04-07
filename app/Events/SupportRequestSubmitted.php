<?php

namespace App\Events;

use App\Models\SupportRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupportRequestSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public SupportRequest $supportRequest)
    {
    }
}
