<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MagicLoginLink extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;
    public string $name;

    /**
     * Create a new message instance.
     */
    public function __construct(string $url, string $name = '')
    {
        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Magic Login Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.magic_login_link',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
