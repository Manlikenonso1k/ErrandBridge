<x-filament-panels::page>
    <x-filament::section :heading="$this->errand->title">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">{{ str_replace('_', ' ', $this->errand->status) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Budget (USDT)</p>
                <p class="font-medium">{{ number_format((float) $this->errand->budget_usdt, 2) }}</p>
            </div>
        </div>
    </x-filament::section>

    <x-filament::section heading="Milestone Timeline">
        <div class="space-y-2">
            @forelse ($this->getMilestones() as $milestone)
                <div class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                    <div class="font-medium">{{ $milestone->title }}</div>
                    <div class="text-xs text-gray-500">{{ $milestone->status }} @if($milestone->completed_at)· {{ $milestone->completed_at->format('M d, Y H:i') }} @endif</div>
                    @if ($milestone->description)
                        <div class="mt-1 text-sm">{{ $milestone->description }}</div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">No milestones added yet.</p>
            @endforelse
        </div>
    </x-filament::section>

    <x-filament::section heading="Proof of Work Upload">
        <form wire:submit="submitProof" class="space-y-3">
            <input type="file" wire:model="proofFile" accept=".jpg,.jpeg,.png,.webp,.pdf" class="fi-input w-full" />
            <x-filament::input.wrapper>
                <x-filament::input wire:model="proofNotes" placeholder="Proof note (optional)" />
            </x-filament::input.wrapper>
            @error('proofFile') <p class="text-danger-600 text-sm">{{ $message }}</p> @enderror
            <x-filament::button type="submit">Upload Proof</x-filament::button>
        </form>

        <div class="mt-4 space-y-2">
            @forelse ($this->getProofs() as $proof)
                <div class="rounded-lg border border-gray-200 p-3 text-sm dark:border-gray-700">
                    <a href="{{ $this->getProofUrl($proof->file_path) }}" target="_blank" class="font-medium text-primary-600">View proof file</a>
                    <div class="text-gray-500">{{ $proof->notes }}</div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No proof uploads yet.</p>
            @endforelse
        </div>
    </x-filament::section>

    <x-filament::section heading="Chat">
        <livewire:errand-chat :errand-id="$this->errand->id" />
    </x-filament::section>
</x-filament-panels::page>
