<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class SendUserOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;
    public $instituteName;

    /**
     * Create a new message instance.
     *
     * @param  $user
     * @param  $otp
     * @return void
     */
    public function __construct($email, $otp, $instituteName)
    {
        $this->email = $email;
        $this->otp = $otp;
        $this->instituteName = $instituteName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@mais.com', 'SISTEM PENGURUSAN MASJID'),
            subject: 'Pengaktifan Akaun',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_otp',
            with: [

               'email' => $this->email, 
                'otp' => $this->otp,  
                'instituteName' => $this->instituteName,        

            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, 
     */
    public function attachments(): array
    {
        return [];  
    }
}