<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreCompleto;
    public $formName;
    public $formDescription;
    public $formUrl;

    /**
     * Create a new message instance.
     *
     * @param  $nombreCompleto
     * @param  $formName
     * @param  $formDescription
     * @param  $formUrl
     * @return void
     */
    public function __construct($nombreCompleto, $formName, $formDescription, $formUrl)
    {
        $this->nombreCompleto = $nombreCompleto;
        $this->formName = $formName;
        $this->formDescription = $formDescription;
        $this->formUrl = $formUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitación a contestar un formulario',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.formInvitational',
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
