<x-filament-panels::page>
    <div class="grid gap-4 md:grid-cols-2">
        <x-filament::section heading="Connected Wallet">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ $this->getWalletAddress() ?: 'No wallet connected yet.' }}
            </p>
        </x-filament::section>

        <x-filament::section heading="Network Status">
            <div class="inline-flex items-center gap-2 rounded-lg bg-success-50 px-3 py-2 text-success-700 dark:bg-success-500/10 dark:text-success-300">
                <span class="h-2 w-2 rounded-full bg-success-500"></span>
                <span>{{ \App\Filament\Runner\Pages\WithdrawWallet::getNetworkStatus() }} reachable</span>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
