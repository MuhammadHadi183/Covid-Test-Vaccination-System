<?php

namespace App\Mail;

use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HospitalRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hospital $hospital) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hospital registration update',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.hospital-rejected',
            with: ['hospital' => $this->hospital],
        );
    }
}
