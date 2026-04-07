<?php

namespace App\Filament\Runner\Pages;

use App\Models\Errand;
use App\Models\ErrandProof;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ErrandDetail extends Page
{
    use WithFileUploads;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.runner.pages.errand-detail';

    public Errand $errand;

    public ?TemporaryUploadedFile $proofFile = null;

    public string $proofNotes = '';

    public function mount(int|string $record): void
    {
        $this->errand = Errand::query()->with(['sender', 'milestones', 'proofs'])->findOrFail($record);

        abort_unless($this->errand->runner_id === Filament::auth()->id(), 403);

        session(['active_errand_id' => $this->errand->id]);
    }

    public function submitProof(): void
    {
        $this->validate([
            'proofFile' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'proofNotes' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $this->proofFile?->store('errand-proofs', 'public');

        if (! $path) {
            return;
        }

        ErrandProof::create([
            'errand_id' => $this->errand->id,
            'runner_id' => Filament::auth()->id(),
            'file_path' => $path,
            'mime_type' => $this->proofFile?->getMimeType(),
            'notes' => trim(strip_tags($this->proofNotes)),
        ]);

        $this->proofFile = null;
        $this->proofNotes = '';
        $this->errand->refresh();

        Notification::make()->title('Proof uploaded')->success()->send();
    }

    public function getProofs()
    {
        return $this->errand->proofs()->latest()->get();
    }

    public function getMilestones()
    {
        return $this->errand->milestones()->orderBy('created_at')->get();
    }

    public function getProofUrl(string $path): string
    {
        return asset('storage/' . ltrim($path, '/'));
    }
}
