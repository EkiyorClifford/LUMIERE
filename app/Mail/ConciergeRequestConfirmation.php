<?php

namespace App\Mail;

use App\Models\ConciergeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConciergeRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ConciergeRequest $conciergeRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'LUMIERE concierge confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.concierge.customer-confirmation',
            with: ['request' => $this->conciergeRequest],
        );
    }
}
