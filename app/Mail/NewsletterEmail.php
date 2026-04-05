<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageStr;

    public function __construct($subject, $messageStr)
    {
        $this->subject = $subject;
        $this->messageStr = $messageStr;
    }

    public function content(): Content
    {
        $settings = \App\Models\Configuration::pluck('value', 'key');
        $logoPath = $settings->get('site_logo') ? storage_path('app/public/' . $settings->get('site_logo')) : null;
        
        return new Content(
            markdown: 'emails.newsletter',
            with: [
                'body' => $this->messageStr,
                'settings' => $settings,
                'logoPath' => $logoPath,
            ],
        );
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
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
