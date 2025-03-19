<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendUserOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;

    /**
     * Create a new message instance.
     *
     * @param  $user
     * @param  $otp
     * @return void
     */
    public function __construct($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
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