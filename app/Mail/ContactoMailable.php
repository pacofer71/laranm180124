<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

   // public string $nombre, $email, $contenido;
    
    public function __construct(public string $nombre, public string $email, public string $contenido)
    {
       // $this->nombre=$nombre;
       // $this->email=$email;
       // $this->contenido=$contenido;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from:new Address($this->email, $this->nombre),
            subject: 'Formulario de contacto',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //view: 'plantillasmail.contacto',
            markdown: 'plantillasmail.plantillalaravel',
            with:[
                'nombre'=>$this->nombre,
                'email'=>$this->email,
                'contenido'=>$this->contenido
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
