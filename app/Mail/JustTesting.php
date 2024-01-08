<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JustTesting extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        //
    }
    public function build()
    {
        return $this->from('hello@mailtrap.io')
                    ->to('bonjour@mailtrap.io')
                    ->cc('hola@mailtrap.io')
                       ->subject('Auf Wiedersehen')
                       ->markdown('mails.exmpl')
                       ->with([
                         'name' => 'New Mailtrap User',
                         'link' => '/inboxes/'
                       ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Just Testing',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
