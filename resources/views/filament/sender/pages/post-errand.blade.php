<x-filament-panels::page>
	<div class="space-y-4">
		<p class="text-sm text-gray-600">
			Start a new task request with delivery details, budget, and timeline.
		</p>

		<x-filament::button
			tag="a"
			href="{{ \App\Filament\Sender\Resources\ErrandResource::getUrl('create') }}"
			icon="heroicon-o-plus"
		>
			Open Errand Form
		</x-filament::button>
	</div>
</x-filament-panels::page>
