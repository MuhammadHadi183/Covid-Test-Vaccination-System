<?php

namespace App\Mail;

use App\Models\PatientRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PatientRequestToHospitalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PatientRequest $patientRequest)
    {
        $this->patientRequest->loadMissing(['patient.user', 'hospital']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New patient request — '.$this->patientRequest->hospital->hospital_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.patient-request-hospital',
            with: ['request' => $this->patientRequest],
        );
    }
}
