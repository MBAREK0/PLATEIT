<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendForgetPasswordToken extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
   /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
          $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->data;
        return new Envelope(
            subject: $subject['subject'] ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
         $view = $this->data;

    // Check if the 'content' key exists in the $view array
    $content = isset($view['content']) ? $view['content'] : '';

    return (new Content())->view($view['view'])->with('content', $content)->with('subject', $view['subject']);
    }


    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array
    {
        return [];
    }
}
