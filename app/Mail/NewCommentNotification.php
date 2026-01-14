<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCommentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    public $article;

    public function __construct($comment, $article)
    {
        $this->comment = $comment;
        $this->article = $article;
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.comments.new',
            with: [
                'comment' => $this->comment,
                'article' => $this->article,
            ],
        );
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment on: ' . \Illuminate\Support\Str::limit($this->article->title, 20),
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
