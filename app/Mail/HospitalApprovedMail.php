<?php

namespace App\Mail;

use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HospitalApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hospital $hospital) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your hospital account has been approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.hospital-approved',
            with: ['hospital' => $this->hospital],
        );
    }
}
