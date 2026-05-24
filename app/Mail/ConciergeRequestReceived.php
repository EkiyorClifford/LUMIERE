<?php

namespace App\Mail;

use App\Models\ConciergeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConciergeRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ConciergeRequest $conciergeRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New concierge request received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.concierge.admin-received',
            with: ['request' => $this->conciergeRequest],
        );
    }
}
