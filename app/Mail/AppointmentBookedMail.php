<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBookedMail extends Mailable
{
    use Queueable, SerializesModels;

    
    public Appointment $appointment;
    public string $recipientRole;


    public function __construct(Appointment $appointment, string $recipientRole)
    {
        $this->appointment  = $appointment;
        $this->recipientRole = $recipientRole;

      
        $this->appointment->loadMissing(['patient.user', 'hospital']);
    }

  
    public function envelope(): Envelope
    {
    
        if ($this->recipientRole === 'patient') {
            $subject = 'Appointment Confirmation';
        } else {
            $subject = 'New Appointment Booking';
        }

        return new Envelope(subject: $subject);
    }

   
    public function content(): Content
    {
        return new Content(
          
            markdown: 'mail.appointment-booked',

         
            with: [
                'appointment'   => $this->appointment,
                'recipientRole' => $this->recipientRole,
            ],
        );
    }
}