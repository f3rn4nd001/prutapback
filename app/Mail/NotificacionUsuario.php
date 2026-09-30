<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionUsuario extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $datos;

    public function __construct($datos)
    {
        $this->datos = $datos;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificacion Usuario',
        );
    }

    /**
     * Get the message content definition.
     */

     public function build()
    {
    return $this->view('emails.notificacion')
        ->subject('Notificación importante')
        ->with([
            'password' => $this->datos['password'],
            'mensaje' => $this->datos['mensaje'],
        ]);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.notificacion',
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
