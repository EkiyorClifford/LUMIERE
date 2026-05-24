<?php

namespace App\Mail;

use App\Models\BespokeProject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultantContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public BespokeProject $project) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New bespoke project consultation request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.consultant.contact-notification',
            with: ['project' => $this->project],
        );
    }
}
