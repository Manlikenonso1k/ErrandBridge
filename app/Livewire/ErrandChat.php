<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Errand;
use App\Models\ErrandMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ErrandChat extends Component
{
    public ?int $errandId = null;

    public string $message = '';

    public string $newMessage = '';

    public function mount(?int $errandId = null): void
    {
        $this->errandId = $errandId;
        $this->markMessagesRead();
    }

    public function getErrandProperty(): Errand
    {
        return Errand::query()->findOrNew($this->errandId ?? 0);
    }

    public function getMessagesProperty()
    {
        return ErrandMessage::query()
            ->with(['sender', 'receiver'])
            ->where('errand_id', $this->errandId ?? 0)
            ->orderBy('created_at')
            ->get();
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => ['nullable', 'string', 'max:5000'],
        ]);

        if ($this->newMessage === '') {
            return;
        }

        $user = Auth::user() ?? User::query()->first();

        if (! $user) {
            return;
        }

        $receiverId = (int) ($this->errand?->runner_id ?? $this->errand?->sender_id ?? $user->id);

        $message = ErrandMessage::create([
            'errand_id' => $this->errandId ?? 0,
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $this->newMessage,
            'message_type' => 'text',
            'is_read' => false,
        ]);

        $this->newMessage = '';
        $this->markMessagesRead();
        event(new MessageSent($message));
    }

    public function markMessagesRead(): void
    {
        if (! Auth::check()) {
            return;
        }

        ErrandMessage::query()
            ->where('errand_id', $this->errandId ?? 0)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function render()
    {
        return view('livewire.errand-chat', [
            'messages' => $this->messages,
            'errand' => $this->errand,
        ]);
    }
}