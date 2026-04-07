@if ($errand)
    @php
        $isRunnerMap = request()->is('runner/runner-map');
    @endphp

    <div class="fi-section-content-ctn {{ $isRunnerMap ? 'pointer-events-none fixed inset-x-4 top-4 z-50 mb-0' : 'mb-3' }}">
        <div class="rounded-xl border border-warning-300 bg-warning-50/90 p-3 text-sm text-warning-900 backdrop-blur-sm dark:border-warning-500/30 dark:bg-warning-500/20 dark:text-warning-200">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <strong>Active Errand:</strong> {{ $errand->title }}
                    <span class="ms-2 rounded bg-warning-200 px-2 py-1 text-xs uppercase">{{ str_replace('_', ' ', $errand->status) }}</span>
                </div>
                <a class="fi-btn fi-btn-size-sm fi-btn-color-warning pointer-events-auto" href="{{ url('/runner/errand-detail/' . $errand->id) }}">
                    Resume
                </a>
            </div>
        </div>
    </div>
@endif
