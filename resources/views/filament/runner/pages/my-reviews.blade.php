<x-filament-panels::page>
    <x-filament::section heading="Average Rating">
        <div class="text-3xl font-semibold">{{ number_format($this->getAverageRating(), 1) }} / 5</div>
    </x-filament::section>

    <x-filament::section heading="Feedback from Senders">
        <div class="space-y-3">
            @forelse ($this->getReviews() as $review)
                <div class="rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                    <div class="mb-1 text-sm text-gray-500">{{ $review->errand?->title }} · {{ $review->created_at?->format('M d, Y') }}</div>
                    <div class="mb-1 font-medium">{{ str_repeat('★', (int) $review->stars) }}</div>
                    <p class="text-sm">{{ $review->feedback ?: 'No written feedback.' }}</p>
                </div>
            @empty
                <p class="text-sm text-gray-500">No reviews yet.</p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-panels::page>
