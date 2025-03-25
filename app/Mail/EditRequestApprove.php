<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class EditRequestApprove extends Mailable
{
    use Queueable, SerializesModels;

    public $instituteName;
    public $fin_year;
    public $fin_category;
    /**
     * Create a new message instance.
     */
    public function __construct($instituteName, $fin_category, $fin_year)
    {
        $this->instituteName = $instituteName;
        $this->fin_category = $fin_category;
        $this->fin_year = $fin_year;
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
            view: 'emails.edit_request_approve',
            with: [

               'instituteName' => $this->instituteName, 
                'fin_category' => $this->fin_category,    
                'fin_year' => $this->fin_year,      
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
