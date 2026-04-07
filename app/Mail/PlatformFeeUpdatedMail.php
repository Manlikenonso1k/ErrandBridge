<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlatformFeeUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public object $user,
        public bool $enabled,
        public float $percentage,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ErrandBridge Platform Update: Fee Policy Change',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.platform-fee-updated',
            with: [
                'user' => $this->user,
                'enabled' => $this->enabled,
                'percentage' => $this->percentage,
            ],
        );
    }
}