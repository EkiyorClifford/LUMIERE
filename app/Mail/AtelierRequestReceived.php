<?php

namespace App\Mail;

use App\Models\AtelierRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AtelierRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AtelierRequest $atelierRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New atelier visit request received',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.atelier.admin-received',
            with: ['request' => $this->atelierRequest],
        );
    }
}
