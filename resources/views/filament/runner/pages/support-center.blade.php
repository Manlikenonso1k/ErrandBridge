<x-filament-panels::page>
    <x-filament::section heading="FAQ">
        <div class="space-y-3">
            <details class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                <summary class="cursor-pointer font-medium">How do I get paid in USDT?</summary>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Complete an errand and wait for escrow release confirmation on-chain.</p>
            </details>
            <details class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                <summary class="cursor-pointer font-medium">What if a sender disputes my delivery?</summary>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Submit proof files and keep all communication in-platform for auditability.</p>
            </details>
        </div>
    </x-filament::section>

    <x-filament::section heading="Contact Support">
        <form wire:submit="submit" class="space-y-4">
            {{ $this->form }}
            <x-filament::button type="submit">Submit Request</x-filament::button>
        </form>
    </x-filament::section>
</x-filament-panels::page>
