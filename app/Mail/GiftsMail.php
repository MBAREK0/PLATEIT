<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class GiftsMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data ;
    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $imagePath = public_path('images/gifts/email_gifts/'.$this->data['Ticket']);

        try {
            // Embed the image directly in the email body
            return $this->view('mail.Gift')
                ->subject('Email with Embedded Image')
                ->embed($imagePath, 'embedded_image')
                ->with('data', $this->data);
        } catch (\Exception $e) {
            Log::error('Error building email: ' . $e->getMessage());
            return $this->view('mail.Gift')
                ->subject('Email with Embedded Image')
                ->with('data', $this->data);
        }
    }
}

