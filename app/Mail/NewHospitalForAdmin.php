<?php

namespace App\Mail;

use App\Models\Hospital;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewHospitalForAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Hospital $hospital) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New hospital registration — '.$this->hospital->hospital_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-hospital-for-admin',
            with: [
                'hospital' => $this->hospital,
                'approveUrl' => URL::temporarySignedRoute(
                    'admin.hospital.approve-link',
                    now()->addDays(7),
                    ['Id' => $this->hospital->id]
                ),
            ],
        );
    }
}
