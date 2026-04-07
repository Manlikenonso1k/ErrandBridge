<div class="card border-info shadow-sm">
    <div class="card-body">
        <h6 class="card-title mb-3">Platform Fee Breakdown</h6>

        @if ($breakdown['fee_enabled'])
            <div class="d-flex justify-content-between">
                <span>Platform fee ({{ $breakdown['fee_rate'] }}%)</span>
                <strong>{{ number_format($breakdown['fee_amount'], 2) }} USDT</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Runner receives</span>
                <strong>{{ number_format($breakdown['net_to_runner'], 2) }} USDT</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>You pay</span>
                <strong>{{ number_format($breakdown['gross'], 2) }} USDT</strong>
            </div>
        @else
            <div class="alert alert-success mb-0">🎉 No platform fee applied — runner receives 100% of budget</div>
        @endif
    </div>
</div>