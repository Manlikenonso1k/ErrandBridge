<div class="card shadow-sm h-100">
    <div class="card-header bg-warning-subtle border-warning">
        <strong>⚠️ Safety Notice:</strong> All errand communications must remain within ErrandBridge. Moving conversations to WhatsApp, WeChat, Telegram, or any external platform is a violation of our Terms of Service. ErrandBridge is not liable for any losses, fraud, or disputes arising from off-platform communication. Your account may be suspended for violations.
    </div>

    <div class="card-body d-flex flex-column" style="min-height: 520px;">
        <div class="flex-grow-1 overflow-auto mb-3" id="errand-chat-scroll">
            @foreach ($messages as $message)
                @if ($message->message_type === 'system')
                    <div class="text-center text-muted fst-italic my-2">
                        {{ $message->message }}
                    </div>
                @else
                    <div class="d-flex mb-3 {{ auth()->id() === $message->sender_id ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="rounded-3 px-3 py-2 {{ auth()->id() === $message->sender_id ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 85%;">
                            <div class="small opacity-75 mb-1">
                                {{ $message->sender->name ?? 'User' }} · {{ $message->created_at?->format('M d, H:i') }}
                            </div>
                            <div>{{ $message->message }}</div>
                            @if ($message->is_read)
                                <div class="text-end small mt-1 {{ auth()->id() === $message->sender_id ? 'text-white-50' : 'text-muted' }}">Read</div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <form wire:submit.prevent="sendMessage" class="mt-auto">
            <div class="input-group">
                <textarea wire:model="newMessage" class="form-control" rows="2" placeholder="Type a message..."></textarea>
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="chatSafetyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Keep It Safe, Keep It Here</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please keep all conversations inside ErrandBridge. Moving to WhatsApp, WeChat, Telegram, or any external platform is against our Terms and may result in suspension.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    @once
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const key = 'errandbridge-chat-warning-seen';
                    if (!localStorage.getItem(key)) {
                        const modal = new bootstrap.Modal(document.getElementById('chatSafetyModal'));
                        modal.show();
                        localStorage.setItem(key, '1');
                    }

                    const scroll = document.getElementById('errand-chat-scroll');
                    if (scroll) {
                        scroll.scrollTop = scroll.scrollHeight;
                    }
                });
            </script>
        @endpush
    @endonce
</div>