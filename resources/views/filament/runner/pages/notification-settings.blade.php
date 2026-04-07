<x-filament-panels::page>
    <x-filament::section heading="Alert Preferences">
        <form wire:submit="save" class="space-y-4">
            {{ $this->form }}
            <x-filament::button type="submit">Save Preferences</x-filament::button>
        </form>
    </x-filament::section>

    <x-filament::section heading="Notification Log">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="py-2">Channel</th>
                        <th class="py-2">Title</th>
                        <th class="py-2">Sent</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->getLogs() as $log)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="py-2">{{ $log->channel }}</td>
                            <td class="py-2">{{ $log->title }}</td>
                            <td class="py-2">{{ $log->sent_at?->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-3 text-gray-500">No notification logs yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
