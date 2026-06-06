<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerNotification extends Mailable
{
    use Queueable, SerializesModels;


    public $mailData;
    public $viewName;


    public function __construct($mailData, $viewName)
    {
        $this->mailData = $mailData;
        $this->viewName = $viewName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['title'] ?? 'SoftMail - Yeni Bildiriş',
        );
    }

  
    public function content(): Content
    {
        return new Content(
            view: $this->viewName,
          
            with: $this->mailData,
        );
    }

  
    public function attachments(): array
    {
        return [];
    }
}
