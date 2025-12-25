<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $password;

    public function __construct(Appointment $appointment, $password)
    {
        $this->appointment = $appointment;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pendaftaran Berhasil - ' . $this->appointment->appointment_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}