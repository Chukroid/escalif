<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class CorreoBoleta extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfData;
    public $fileName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $pdfData, string $fileName = 'boleta.pdf')
    {
        $this->pdfData = $pdfData;
        $this->fileName = $fileName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reporte de Calificaciones para ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.boleta', // Create this Blade view for the email body
            // You can pass data to the email view like this:
            with: [
                'reportDate' => now()->format('d/m/Y H:i'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => base64_decode($this->pdfData), $this->fileName)
                      ->withMime('application/pdf'),
        ];
    }
}
