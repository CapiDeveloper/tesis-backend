<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RestablecerClaveMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('envia@correo.com','Robert Brito'),
            subject: 'Restablecer Contraseña Mailable',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.restablecer-clave',
            with: ['url' => $this->url],
        );
    }

    public function attachments()
    {
        return [];
    }
}
